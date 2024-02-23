<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


use Symfony\Component\HttpFoundation\Request;


#[Route('/admin')]
class AdminController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/{idA}', name: 'app_admin')]
    public function index(int $idA): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'admin_id' => $idA,

        ]);
    }
    

    
}
