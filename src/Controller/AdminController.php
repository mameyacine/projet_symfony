<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;




#[Route('/admin/{idA}')]
class AdminController extends AbstractController
{


    #[Route('/', name: 'app_admin')]
    public function index(int $idA, Request $request, SessionInterface $session, UserRepository $userRepository): Response
    {
        // Récupérer l'utilisateur à partir de l'ID
        $user = $userRepository->find($idA);

        // Récupérer le thème stocké en session
        $theme = $session->get('theme', 'light');

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'admin_id' => $idA,
            'admin_user' => $user, 
            'theme' => $theme, 
        ]);
    }
    

    #[Route('/change-theme', name: 'app_admin_change_theme')]
    public function changeTheme(int $idA, Request $request, SessionInterface $session, RouterInterface $router): Response
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
            return $this->redirectToRoute('app_admin', ['idA' => $idA]);
        }
    }

}
