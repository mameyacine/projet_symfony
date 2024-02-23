<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\NoteStudent;
use App\Entity\QCM;
use App\Entity\Question;
use App\Repository\NoteStudentRepository;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use App\Repository\QCMRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/student/{idS}')]
class StudentQCMController extends AbstractController
{

    private $userRepository;
    private $noteStudentRepository;
    private $QCMRepository;
    private $questionRepository;
    private $courseRepository;
    private $threshold;
    private $doctrine;
    private $entityManager;
// Modifier le constructeur pour initialiser CourseRepository
public function __construct(ManagerRegistry $doctrine, UserRepository $userRepository, NoteStudentRepository $noteStudentRepository, QCMRepository $QCMRepository, QuestionRepository $questionRepository, CourseRepository $courseRepository, EntityManagerInterface $entityManager, int $threshold = 70)
{
    // Assigner les dépendances aux propriétés de la classe
    $this->userRepository = $userRepository;
    $this->noteStudentRepository = $noteStudentRepository;
    $this->QCMRepository = $QCMRepository;
    $this->questionRepository = $questionRepository;
    $this->courseRepository = $courseRepository; // Ajouter cette ligne
    $this->threshold = $threshold;
    $this->doctrine = $doctrine;
    $this->entityManager = $entityManager;
}

    const MAX_ATTEMPTS = 3;

    #[Route('/student/qcm', name: 'app_student_q_c_m')]
    public function index(): Response
    {
        return $this->render('student_qcm/index.html.twig', [
            'controller_name' => 'StudentQCMController',
        ]);
    }

    #[Route('/courses/{courseId}/qcm/{qcmId}', name: 'student_qcm', methods: ['GET'])]
    public function showRandomQcm(QCMRepository $QCMRepository, CourseRepository $courseRepository, QuestionRepository $questionRepository, int $idS, int $courseId, int $qcmId, NoteStudentRepository $noteStudentRepository): Response
    {
        // Vérifier le nombre de fois que l'utilisateur a passé ce QCM
        $userAttempts = $noteStudentRepository->countAttemptsByUserAndQCM($idS, $qcmId);
    
        // Vérifier si l'utilisateur peut passer le QCM une autre fois
        if ($userAttempts >= self::MAX_ATTEMPTS) {            // Si l'utilisateur a déjà passé le QCM trois fois, rediriger ou renvoyer un message d'erreur
            return $this->redirectToRoute('student_course_error', ['error' => 'Vous avez déjà passé ce QCM trois fois.']);
        }
    
        // Récupérer un cours
        $course = $courseRepository->find($courseId);
    
        if (!$course) {
            throw $this->createNotFoundException('Le cours demandé n\'existe pas.');
        }
    
        // Vérifier si le cours a le QCM spécifié
        $qcm = $QCMRepository->findOneBy(['id' => $qcmId, 'course' => $course]);
    
        if (!$qcm) {
            throw $this->createNotFoundException('Le QCM demandé n\'existe pas pour ce cours.');
        }
    
        // Récupérer les questions associées au QCM
        $questions = $questionRepository->findBy(['qcm' => $qcm]);
    
        return $this->render('student_course/qcm.html.twig', [
            'qcm' => $qcm,
            'questions' => $questions,
            'student_id' => $idS,
        ]);
    }
    

   
    #[Route('/courses/{courseId}/qcm/{qcmId}/submit_qcm', name: 'submit_qcm', methods: ['POST'])]
    public function submitQcm(Request $request, int $idS, int $courseId, int $qcmId, NoteStudentRepository $noteStudentRepository): Response
    {
        // Vérifier le nombre de fois que l'utilisateur a passé ce QCM
        $userAttempts = $noteStudentRepository->countAttemptsByUserAndQCM($idS, $qcmId);
        $userAttempts++;
        // Vérifier si l'utilisateur peut passer le QCM une autre fois
        if ($userAttempts >= self::MAX_ATTEMPTS) {
            // Si l'utilisateur a déjà passé le QCM trois fois, rediriger ou renvoyer un message d'erreur
            return $this->redirectToRoute('student_course_error', ['error' => 'Vous avez déjà passé ce QCM trois fois.']);
        }
    
        $scorePercentage = $this->calculateStudentScore($request->request->all()['answers'], $qcmId);
        $previousScore = $noteStudentRepository->findOneBy(['users' => $idS, 'QCMs' => $qcmId]);

    
        // Vérifie si le résultat n'est pas null et si c'est une instance de NoteStudent
        if ($previousScore !== null && $previousScore instanceof NoteStudent) {
            // Comparer les scores uniquement si le résultat est conforme à nos attentes
            if ($scorePercentage > $previousScore->getScore()) {
                // Mettre à jour la base de données uniquement si la note est supérieure à celle précédente
                $this->updateStudentScore($idS, $qcmId, $scorePercentage);
            }
        } elseif ($previousScore !== null) {
            // Si le résultat n'est pas null mais n'est pas une instance de NoteStudent, cela peut indiquer un problème
            throw new \RuntimeException('La méthode findOneBy a retourné un objet inattendu.');
        } else {
            // Si le résultat est null, cela signifie qu'il n'y a pas de score précédent pour cet utilisateur et ce QCM
            $this->updateStudentScore($idS, $qcmId, $scorePercentage);
        }
    
        $cookie = new Cookie('qcm_results', json_encode(['qcm_id' => $qcmId, 'score' => $scorePercentage, ]), strtotime('+1 day'));
        // Créer une réponse avec une redirection
        $response = $this->redirectToRoute('recommendations', ['idS' => $idS]);
        // Ajouter le cookie à la réponse
        $response->headers->setCookie($cookie);
    
        // Retourner la réponse avec la redirection et le cookie
        return $response;
    

    }
    

    public function updateStudentScore(int $userId, int $qcmId, float $scorePercentage): void
    {
        $entityManager = $this->doctrine->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        $QCMRepository = $entityManager->getRepository(QCM::class);
        $user = $userRepository->find($userId);
        $qcm = $QCMRepository->find($qcmId);
    
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé pour l\'ID donné.');
        }
    
        if (!$qcm) {
            throw $this->createNotFoundException('QCM non trouvé pour l\'ID donné.');
        }
    
        // Utiliser la méthode findOneBy pour obtenir le score précédent
        $previousScore = $this->noteStudentRepository->findOneBy(['users' => $user, 'QCMs' => $qcm]);
    
        // Vérifier si le résultat est un objet NoteStudent
        if ($previousScore instanceof NoteStudent) {
            // Accéder au score précédent
            $previousScoreValue = $previousScore->getScore();
    
            // Assurez-vous que le résultat retourné est un nombre flottant
            if (!is_float($previousScoreValue)) {
                throw new \InvalidArgumentException('Le score précédent n\'a pas le bon format.');
            }
    
            // Vérifier si le nouveau score est supérieur au score précédent
            if ($scorePercentage > $previousScoreValue) {
                // Mettre à jour le score existant
                $previousScore->setScore($scorePercentage);
                $entityManager->flush();
            }
        } else {
            // Créer une nouvelle entité NoteStudent
            $noteStudent = new NoteStudent();
            $noteStudent->setUsers($user);
            $noteStudent->setQCMs($qcm);
            $noteStudent->setScore($scorePercentage);
            $entityManager->persist($noteStudent);
            $entityManager->flush();
        }
    }
    

    
    private function calculateStudentScore(array $qcmData, int $qcmId): float
    {
        // Récupérer les questions du même QCM
        $questions = $this->questionRepository->findBy(['qcm' => $qcmId]);

        // Initialiser le nombre de réponses correctes
        $correctAnswersCount = 0;

        foreach ($questions as $question) {
            $questionId = $question->getId();
            // Vérifier si la question a été répondu par l'utilisateur
            if (isset($qcmData[$questionId])) {
                $userAnswerIndex = (int) $qcmData[$questionId];
                // Récupérer l'index de la réponse correcte pour cette question
                $correctAnswerIndex = (int) $question->getCorrectAnswerIndex();
                // Comparer l'index de la réponse de l'utilisateur avec l'index de la réponse correcte
                if ($userAnswerIndex === $correctAnswerIndex) {
                    // Si la réponse est correcte, incrémenter le compteur des réponses correctes
                    $correctAnswersCount++;
                }
            }
        }

        // Calculer le score en pourcentage
        $totalQuestions = count($questions);
        $scorePercentage = ($correctAnswersCount / $totalQuestions) * 100;

        return $scorePercentage;
    }

        
    
    #[Route('/recommendations', name: 'recommendations')]
    public function recommendations(Request $request, int $idS, QCMRepository $QCMRepository, QuestionRepository $questionRepository): Response
    {
        // Récupérer les réponses du QCM depuis les cookies
        $qcmResults = json_decode($request->cookies->get('qcm_results'), true);
        //dump($qcmResults);
        // Vérifier si les données du QCM peuvent être décodées depuis le cookie
        if ($qcmResults === null || !isset($qcmResults['qcm_id'])) {
            throw new \InvalidArgumentException('Les données du QCM ne peuvent pas être décodées depuis le cookie ou l\'ID du QCM est manquant.');
        }
    
        // Récupérer l'ID du QCM à partir des données du cookie
        $qcmId = $qcmResults['qcm_id'];
    
        // Récupérer le QCM à partir de son ID
        $qcm = $QCMRepository->find($qcmId);
        //dump($qcm);
        // Vérifier si le QCM existe
        if (!$qcm) {
            throw $this->createNotFoundException('Le QCM correspondant n\'a pas été trouvé.');
        }
    
        // Récupérer les questions associées à ce QCM
        $questions = $questionRepository->findBy(['qcm' => $qcmId]);
        //dump($questions);
        // Vérifier si des questions ont été trouvées
        if (!$questions) {
            throw $this->createNotFoundException('Aucune question n\'a été trouvée pour ce QCM.');
        }
    
        // Exemple de logique de recommandation de cours basée sur les réponses du QCM
        // Appel de la méthode recommendCourses avec l'ID du QCM
        $recommendedCourses = $this->recommendCourses($qcmResults, $qcmId);
            
        // Calculer le score de l'étudiant
        $studentScore = $this->calculateStudentScore($qcmResults, $qcmId);
    
        // Déterminer les leçons non trouvées par l'étudiant dans le cours
        $missingLessons = $this->findLessonsWithIncorrectAnswers($qcmResults);
    
        $threshold = 70;
    
        // Si le score de l'étudiant est inférieur au seuil, lui recommander de refaire le cours
        if ($studentScore < $threshold) {
            $recommendation = 'Nous vous recommandons de refaire le cours en vous concentrant sur les leçons suivantes : ' . implode(', ', $missingLessons);
        } else {
            // Sinon, lui recommander d'explorer d'autres cours du même thème
            $recommendation = 'Votre score est suffisamment élevé. Vous pouvez explorer d\'autres cours du même thème.';
        }
    
        // Afficher les recommandations à l'utilisateur
        return $this->render('student_qcm/recommendations.html.twig', [
            'recommended_courses' => $recommendedCourses,
            'recommendation' => $recommendation,
            'idS' => $idS,
        ]);
    }
    

    
    
    
    // Méthode pour trouver les leçons non trouvées par l'étudiant dans le cours
    private function findLessonsWithIncorrectAnswers(array $qcmData): array
    {
        // Vérifier si l'identifiant du QCM est présent dans les données
        if (!isset($qcmData['qcm_id'])) {
            throw new \InvalidArgumentException('L\'identifiant du QCM est manquant dans les données.');
        }
    
        // Récupérer l'identifiant du QCM à partir des données
        $qcmId = $qcmData['qcm_id'];
        //dump($qcmData);
        // dump($qcmId);
    
        // Récupérer le QCM associé à l'identifiant
        $qcm = $this->QCMRepository->find($qcmId);
        // dump($qcm);
    
        // Récupérer les questions associées au QCM
        $questions = $this->questionRepository->findBy(['qcm' => $qcm]);
        //dump($questions);
        // Initialiser un tableau pour stocker les leçons avec des réponses incorrectes
        $lessonsWithIncorrectAnswers = [];
    
        // Parcourir chaque question pour vérifier si l'utilisateur a donné une réponse incorrecte
        foreach ($questions as $question) {
            // Récupérer l'identifiant de la question
            $questionId = $question->getId();
        //dump($questionId);
            
            // Vérifier si l'indice de réponse de l'utilisateur pour cette question existe dans $qcmData
            if (isset($qcmData[$questionId])) {
                // Récupérer l'indice de réponse de l'utilisateur et l'indice de la réponse correcte
                $userAnswerIndex = (int) $qcmData[$questionId];
                //dump($userAnswerIndex);
                $correctAnswerIndex = $question->getCorrectAnswerIndex();
                //dump($correctAnswerIndex);
    
                // Vérifier si l'utilisateur a donné une réponse incorrecte
                if ($userAnswerIndex !== $correctAnswerIndex) {
                    // Récupérer la leçon associée à cette question
                    $lesson = $question->getLesson();
                    if ($lesson && !in_array($lesson, $lessonsWithIncorrectAnswers, true)) {
                        // Ajouter la leçon à la liste si elle n'est pas déjà présente
                        $lessonsWithIncorrectAnswers[] = $lesson;
                    }
                }
            }
        }
    
        return $lessonsWithIncorrectAnswers;
    }
    



        
        
        

    private function recommendCourses(array $qcmData, int $qcmId): array
    {
        // Récupérer les questions du QCM
        $questions = $this->questionRepository->findBy(['qcm' => $qcmId]);

        // Si l'étudiant a dépassé le seuil, recommandez des cours du même thème
        if ($this->calculateStudentScore($qcmData, $qcmId) >= $this->threshold) {
            // Identifiez le thème du cours réussi, par exemple en utilisant les compétences ou les sujets abordés
            $successfulCourseTheme = $this->identifyCourseTheme($qcmData);
            // Recherchez d'autres cours similaires dans votre base de données
            $similarCourses = $this->courseRepository->findSimilarCourses($successfulCourseTheme);

            return $similarCourses;
        }
        // Si l'étudiant n'a pas dépassé le seuil, retournez une liste vide
        return [];
    }

        

    private function identifyCourseTheme(array $qcmData): int
    {
        // Vérifier si l'identifiant du QCM est présent dans les données
        if (!isset($qcmData['qcm_id'])) {
            throw new \InvalidArgumentException('L\'identifiant du QCM est manquant dans les données.');
        }
        // Récupérer l'identifiant du QCM à partir des données
        $qcmId = $qcmData['qcm_id'];
        // Récupérer le QCM associé à l'identifiant
        $qcm = $this->QCMRepository->find($qcmId);
        // Vérifier si le QCM existe
        if (!$qcm) {
            throw $this->createNotFoundException('Le QCM demandé n\'existe pas.');
        }
        // Récupérer le cours associé au QCM
        $course = $qcm->getCourse();
        // Récupérer l'objet Theme associé au cours
        $theme = $course->getTheme();
        // Récupérer l'identifiant du thème du cours
         $themeId = $theme->getId();
        // Retourner l'identifiant du thème du cours
        return $themeId;
    }
}
