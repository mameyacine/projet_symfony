<?php

namespace App\Controller;

use App\Entity\QCM;
use App\Entity\Question;
use App\Form\QCMType;
use App\Form\QuestionType;
use App\Entity\Course;
use App\Repository\QCMRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Encoder\XmlEncoder;


class QCMController extends AbstractController

{
        private $doctrine;

    
        public function __construct(ManagerRegistry $doctrine)
        {
            $this->doctrine = $doctrine;

        }
    
        
    
  
    #[Route('/admin/{idA}/qcmList', name: 'qcm_list')]
    public function list(int $idA): Response
    {
        // Récupérer le EntityManager
        $entityManager = $this->doctrine->getManager();
        
        // Récupérer tous les QCM depuis la base de données
        $qcms = $entityManager->getRepository(QCM::class)->findAll();
        
        // Récupérer les détails du cours correspondant
        $courses = $entityManager->getRepository(Course::class)->findAll();
        
        // Afficher les QCM dans un template Twig avec les détails du cours correspondant
        return $this->render('qcm/list.html.twig', [
            'qcms' => $qcms,
            'courses' => $courses,
            'admin_id' => $idA,
            // Ajoutez la variable 'course_id'
        ]);
    }
    
    


    #[Route('admin/{idA}/qcm/create', name: 'qcm_create')]
    public function createQCM(Request $request, SerializerInterface $serializer, int $idA): Response
    {
        $qcm = new QCM();
        // Créez le formulaire à partir du type de formulaire QCMType
        $form = $this->createForm(QCMType::class, $qcm);
        // Traitez la soumission du formulaire
        $form->handleRequest($request);
        $courseId = null;
        if ($qcm->getCourse() !== null) {
            $courseId = $qcm->getCourse()->getId();
        }
        if ($form->isSubmitted() && $form->isValid()) {
            // Exclure les propriétés cours de l'objet QCM pour éviter la référence circulaire
            $context = [
                'ignored_attributes' => ['course']
            ];
    
            // Utilisez le Serializer pour transformer l'objet QCM en XML
            $xmlContent = $serializer->serialize($qcm, 'xml', $context);
    
            // Enregistrez le QCM dans la base de données si nécessaire
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($qcm);
            $entityManager->flush();
    
            // Enregistrez le contenu XML dans un fichier
            $this->saveQCMXmlToFile($qcm, $xmlContent);
    
            // Redirigez l'utilisateur vers une page de confirmation ou affichez un message de succès
            return $this->redirectToRoute('qcm_list' , ['idA' => $idA]);
        }
    
        return $this->render('qcm/qcm_create.html.twig', [
            'form' => $form->createView(),
            'admin_id' => $idA,
            'course_id'=>$courseId
        ]);
    }
    


    #[Route('admin/{idA}/course/{idC}/qcm/{id}', name: 'qcm_show', methods: ['GET'])]
    public function show(int $idA, int $idC, int $id): Response
    {
        $qcm = $this->doctrine->getRepository(QCM::class)->find($id);
        
        if (!$qcm) {
            throw $this->createNotFoundException('QCM not found');
        }
        
        return $this->render('qcm/show.html.twig', [
            'qcm' => $qcm,
            'idC' =>$idC,
            'admin_id' => $idA
        ]);
    }
    


    
    

    
    
    
    
    private function saveQCMXmlToFile(QCM $qcm): void
    {
        // Récupérer les données du QCM
        $qcmData = [
            'title' => $qcm->getTitle(), // Titre du QCM
            'course' => $qcm->getCourse()->getName(), // Nom du cours associé au QCM
            'questions' => [],
        ];
        
        // Récupérer les questions du QCM
        $questions = $qcm->getQuestions();
        
        // Boucle sur chaque question pour récupérer ses données
        foreach ($questions as $question) {
            $questionData = [
                'lesson' => $question->getLesson()->getName(), // Nom de la leçon associée à la question
                'content' => $question->getContent(),
                'answers' => $question->getAnswers(),
                'correctAnswerIndex' => $question->getCorrectAnswerIndex(),
                // Ajoutez d'autres données de question si nécessaire
            ];
            $qcmData['questions'][] = $questionData;
        }
    
        // Convertir les données en format XML
        $xmlEncoder = new XmlEncoder();
        $xmlContent = $xmlEncoder->encode($qcmData, 'xml');
        
       
     // Spécifier le chemin complet où vous souhaitez enregistrer le fichier XML
     $filePath = __DIR__ . '/../../src/Command/qcms/qcm_' . $qcm->getId() . '.xml';

     // Vérifier si le dossier qcms existe, sinon le créer de manière récursive
     $directoryPath = dirname($filePath);
     if (!is_dir($directoryPath)) {
         mkdir($directoryPath, 0777, true);
     }
    
        // Enregistrer le contenu XML dans le fichier
        file_put_contents($filePath, $xmlContent);
    }
    

    
    
    
}