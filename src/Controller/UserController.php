<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\UserRepository;


#[Route('/admin/{idA}/user')]
class UserController extends AbstractController
{
    private $userRepository;
    private $doctrine;
    public function __construct(UserRepository $userRepository, EntityManagerInterface $doctrine)
    {
        $this->userRepository = $userRepository;
        $this->doctrine = $doctrine;
    }

    #[Route('/manage-users', name: 'user_index')]
    public function manageUsers(int $idA): Response
    {
        $users = $this->userRepository->findNonAdminUsers();

        return $this->render('user/index.html.twig', [
            'users' => $users,
            'admin_id' => $idA,
        ]);
    }
   
    #[Route('/new', name: 'new_user', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, int $idA): Response
    {
        // Créer une nouvelle instance de l'entité User
        $user = new User();
        // Créer le formulaire à partir du UserType avec l'entité User
        $form = $this->createForm(UserType::class, $user);
        // Gérer la requête
        $form->handleRequest($request);
        // Vérifier si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Hasher le mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('password')->getData());
            $user->setPassword($hashedPassword)->setRoles(['Student']);
            // Persister l'entité User
            $entityManager->persist($user);
            // Exécuter les requêtes SQL en attente
            $entityManager->flush();
            // Redirection vers la page de gestion des utilisateurs
            return $this->redirectToRoute('user_index', ['idA' => $idA]);
        }
        // Rendre le formulaire dans le template twig
        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'admin_id' => $idA
        ]);
    }


    #[Route('/{id}', name: 'show_user', methods: ['GET'])]
    public function show(User $user, int $idA): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'admin_id' => $idA,
            
        ]);
    }


    #[Route('/{id}/edit', name: 'edit_user' , methods: ['GET', 'POST'])]
   public function editUser(Request $request, User $user, EntityManagerInterface $entityManager, int $idA): Response
   {
       $form = $this->createForm(UserType::class, $user);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
           $entityManager->flush();
           return $this->redirectToRoute('user_index', ['idA' => $idA]);
       }
       return $this->render('user/edit.html.twig', [
           'user' => $user,
           'form' => $form,
           'admin_id' => $idA
       ]);
   }


    #[Route('/{id}/delete', name: 'delete_user', methods: ['POST'])]
    public function deleteUser(Request $request, User $user, EntityManagerInterface $entityManager, int $idA): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('user_index', ['idA' => $idA]);
    }
    

}


