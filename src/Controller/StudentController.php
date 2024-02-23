<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Question;
use App\Entity\QCM;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/student/{idS}')]
class StudentController extends AbstractController
{

 
    private $doctrine;
    private $userRepository;

    public function __construct(ManagerRegistry $doctrine, userRepository $userRepository)
    {
        $this->doctrine = $doctrine;
        $this->userRepository = $userRepository;
    }

    #[Route('/', name: 'app_student')]
    public function index(SessionInterface $session, int $idS): Response
    {
        // Vérifier si l'indicateur de première connexion est présent dans la session
        if (!$session->get('first_login')) {
            // Si c'est la première connexion, définir l'indicateur dans la session
            $session->set('first_login', true);
            // Afficher le pop-up avec les thèmes et les cours
            return $this->redirectToRoute('show_popup', ['idS' => $idS]);
        }

        // Sinon, afficher la page d'accueil normale
        return $this->render('student/index.html.twig', [
            'student_id' => $idS,
            ]);
    }






    #[Route('/forum', name: 'student_forum')]
    public function forum(int $idS): Response
    {
        // Exemple de logique pour récupérer les sujets de discussion depuis la base de données
        $courses = $this->doctrine->getRepository(Course::class)->findAll();

        // Rendre la vue du forum avec les sujets de discussion
        return $this->render('student/forum.html.twig', [
            'course' => $courses,
            'student_id' => $idS,
        ]);
    }


    #[Route('/courses', name: 'student_courses')]
    public function course_student(CourseRepository $courseRepository, int $idS): Response
    {
        // Récupérer l'utilisateur actuellement connecté (vous devrez peut-être ajuster cette logique selon votre application)
        $user = $this->getUser();

        // Récupérer les cours auxquels l'utilisateur est inscrit
        $courses = $courseRepository->findCoursesByUser($user);

        // Rendre la vue Twig avec les données nécessaires
        return $this->render('student_course/index.html.twig', [
            'user' => $user,
            'courses' => $courses,
            'student_id' => $idS,
        ]);
    }

  

    

}
