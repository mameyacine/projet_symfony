<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

#[Route('/student/{idS}')]
class StudentController extends AbstractController
{

 

    #[Route('/', name: 'app_student')]
    public function index(SessionInterface $session, int $idS, UserRepository $userRepository): Response
    {

        // Récupérer l'utilisateur à partir de l'ID
        $student = $userRepository->find($idS);
        $theme = $session->get('theme', 'light');

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
            'student' => $student,
            'theme' => $theme,
        ]);
    }

    #[Route('/change-theme', name: 'app_student_change_theme')]
    public function changeTheme(int $idS, Request $request, SessionInterface $session, RouterInterface $router): Response
    {
        // Récupérer le thème sélectionné depuis le formulaire
        $newTheme = $request->request->get('theme');

        // Vérifier si le thème est valide
        if (!in_array($newTheme, ['light', 'dark'])) {
            throw $this->createNotFoundException('Invalid theme.');
        }

        // Stocker le nouveau thème en session
        $session->set('theme', $newTheme);

        // Rediriger l'utilisateur vers la même page
        $referer = $request->headers->get('referer');
        if ($referer) {
            return $this->redirect($referer);
        } else {
            // Si le referer n'est pas disponible, rediriger vers une page par défaut
            return $this->redirectToRoute('app_student', ['idS' => $idS]);
        }
    }




    #[Route('/search_usercourse', name: 'search_usercourse')]
    public function searchUserCourse(Request $request, int $idS, CourseRepository $courseRepository, SessionInterface $session): Response
    {
        // Récupérer le terme de recherche depuis la requête
        $query = $request->query->get('query');

        // Si le terme de recherche est vide, rediriger vers la page d'accueil de l'utilisateur
        if (empty($query)) {
            return $this->redirectToRoute('app_student', ['idS' => $idS]);
        }
        $theme = $session->get('theme', 'light');


        // Rechercher les cours de l'utilisateur correspondant au terme de recherche
        $courses = $courseRepository->searchCoursesByUser($idS, $query); 
        shuffle($courses);
        // Rendre la vue avec les résultats de la recherche
        return $this->render('student_course/search.html.twig', [
            'courses' => $courses,
            'student_id' => $idS,
            'query' => $query,
            'theme' =>$theme,
        ]);
    }



    #[Route('/courses', name: 'student_courses')]
    public function course_student(CourseRepository $courseRepository,SessionInterface $session, int $idS): Response
    {
        $theme = $session->get('theme', 'light');

        // Récupérer l'utilisateur actuellement connecté (vous devrez peut-être ajuster cette logique selon votre application)
        $user = $this->getUser();

        // Récupérer les cours auxquels l'utilisateur est inscrit
        $courses = $courseRepository->findCoursesByUser($user);
        shuffle($courses);

        // Rendre la vue Twig avec les données nécessaires
        return $this->render('student_course/index.html.twig', [
            'user' => $user,
            'courses' => $courses,
            'student_id' => $idS,
            'theme' =>$theme,
        ]);
    }

  

    

}
