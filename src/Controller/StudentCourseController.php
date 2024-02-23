<?php

namespace App\Controller;


use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/student/{idS}')]
class StudentCourseController extends AbstractController
{
  
    private $courseRepository;


    public function __construct( CourseRepository $courseRepository)
    {
     
        $this->courseRepository = $courseRepository;
     
    }

    #[Route('/courses/{courseId}/lessons', name: 'course_lessons')]
    public function showCourseLessons(int $courseId, int $idS): Response
    {
        // Récupérer le cours depuis la base de données
        $course = $this->courseRepository->find($courseId);

        if (!$course) {
            throw $this->createNotFoundException('Le cours n\'existe pas.');
        }

        // Récupérer les leçons associées au cours
        $lessons = $course->getLessons();

        // Récupérer un QCM aléatoire associé au cours
        $qcms = $course->getQcms()->toArray();
        $randomQcm = $qcms[array_rand($qcms)];

        // Afficher la vue Twig des leçons du cours
        return $this->render('student_course/lessons.html.twig', [
            'course' => $course,
            'lessons' => $lessons,
            'idS' => $idS,
            'qcm' => $randomQcm, // Passer le QCM aléatoire à la vue Twig
        ]);
    }





   
}
