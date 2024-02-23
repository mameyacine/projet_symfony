<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\User;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/{idA}/course')]
class CourseController extends AbstractController
{
    private $themeRepository;

// Modifier le constructeur pour initialiser CourseRepository
public function __construct( ThemeRepository $themeRepository)
{
    // Assigner les dépendances aux propriétés de la classe
    $this->themeRepository = $themeRepository;


}
   
    #[Route('/', name: 'index_course', methods: ['GET'])]
    public function index(CourseRepository $courseRepository, int $idA): Response
    {
        return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findAll(),
            'admin_id' => $idA,
        ]);
    }

    
    #[Route('/new', name: 'new_course', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $idA, ThemeRepository $themeRepository): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le thème du nouveau cours
            $themeId = $course->getTheme()->getId();
            $theme = $themeRepository->find($themeId);
    
            // Vérifier si le thème existe
            if (!$theme) {
                throw $this->createNotFoundException('Thème non trouvé avec l\'ID ' . $themeId);
            }
    
            // Récupérer tous les cours associés au thème sélectionné
            $courses = $theme->getCourses();
    
            // Initialise une liste pour stocker les utilisateurs
            $users = [];
    
            // Ajouter les utilisateurs de chaque cours à la liste
            foreach ($courses as $existingCourse) {
                // Récupérer les utilisateurs de chaque cours
                $courseUsers = $existingCourse->getUsers()->toArray();
    
                // Ajouter les utilisateurs à la liste
                foreach ($courseUsers as $user) {
                    $users[] = $user;
                }
            }
    
            // Ajouter les utilisateurs au nouveau cours
            foreach ($users as $user) {
                $course->addUser($user);
            }
    
            // Enregistrer les modifications dans la base de données
            $entityManager->persist($course);
            $entityManager->flush();
    
            return $this->redirectToRoute('index_course', ['idA' => $idA], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('course/new.html.twig', [
            'course' => $course,
            'form' => $form,
            'admin_id' => $idA,
        ]);
    }
    
    
    
    
    
    
    
    


 

    #[Route('/{id}', name: 'show_course', methods: ['GET'])]
    public function show(Course $course, int $idA, LessonRepository $lessonRepository): Response
    {
        $lessons = $lessonRepository->findBy(['course' => $course]);
    
        return $this->render('course/show.html.twig', [
            'course' => $course,
            'admin_id' => $idA,
            'lessons' => $lessons, // Pass lessons to the template
        ]);
    }
    

    #[Route('/{id}/edit', name: 'edit_course', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Course $course, EntityManagerInterface $entityManager, int $idA): Response
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Pas besoin de supprimer le cours ici
            // Il suffit de le mettre à jour dans la base de données
            $entityManager->flush();
    
            // Rediriger vers la page de détails du cours modifié
            return $this->redirectToRoute('index_course', ['idA' => $idA], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('course/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
            'admin_id' => $idA,
        ]);
    }
    
    

    #[Route('/{id}', name: 'delete_course', methods: ['POST'])]
    public function delete(Request $request, Course $course, EntityManagerInterface $entityManager, int $idA): Response
    {
        if ($this->isCsrfTokenValid('delete'.$course->getId(), $request->request->get('_token'))) {
            $entityManager->remove($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('index_course', ['idA' => $idA]);
    }

}    
