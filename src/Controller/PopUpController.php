<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Repository\CourseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student/{idS}')]
class PopUpController extends AbstractController
{
    private $doctrine;
    private $courseRepository;

    public function __construct(ManagerRegistry $doctrine, CourseRepository $courseRepository)
    {
        $this->doctrine = $doctrine;
        $this->courseRepository = $courseRepository;
    }

  

    #[Route('/popup', name: 'show_popup')]
    public function showPopup(int $idS, SessionInterface $session): Response
    {
        $theme = $session->get('theme', 'light');

        // Vérifier si la session indiquant que le pop-up a déjà été affiché existe
        if (!$session->has('popup_shown')) {
            // Si la session n'existe pas, marquez le pop-up comme affiché en définissant une variable de session
            $session->set('popup_shown', true);

            // Récupérer les thèmes et les cours depuis la base de données
            $themes = $this->doctrine->getRepository(Theme::class)->findAll();

            // Afficher le pop-up avec les thèmes et les cours
            return $this->render('popup/index.html.twig', [
                'student_id' => $idS,
                'theme' =>$theme,
                'themes' => $themes,
            ]);
        }

        // Si la session indiquant que le pop-up a déjà été affiché existe, redirigez l'utilisateur vers une autre page
        return $this->redirectToRoute('student_courses', ['idS' => $idS]);
    }

    #[Route('/process/popup/submission', name: 'process_popup_submission', methods: ['POST'])]
    public function processPopupSubmission(Request $request, int $idS, SessionInterface $session): Response
    {
        $theme = $session->get('theme', 'light');

        // Récupérer les données soumises par l'utilisateur à partir du formulaire pop-up
        $formData = $request->request->all();

        // Récupérer l'utilisateur actuellement connecté (vous devrez peut-être ajuster cette logique selon votre application)
        $user = $this->getUser();

        // Vérifier si des données ont été soumises
        if (!empty($formData['themes'])) {
            // Récupérer les thèmes sélectionnés par l'utilisateur
            $selectedThemes = $formData['themes'];

            // Récupérer les cours correspondant aux thèmes sélectionnés
            $courses = $this->courseRepository->findByThemes($selectedThemes);

            // Ajouter l'utilisateur à la liste des utilisateurs inscrits à chaque cours
            foreach ($courses as $course) {
                $course->addUser($user);
                // Vous pouvez également ajouter d'autres logiques ici, comme la vérification si l'utilisateur est déjà inscrit au cours
            }

            // Enregistrer les changements dans la base de données
            $this->doctrine->getManager()->flush();

            // Rediriger vers une page affichant les cours auxquels l'utilisateur est maintenant inscrit
            return $this->redirectToRoute('student_courses', ['idS' => $idS, 'theme' =>$theme]);
        } else {

            // Dans cet exemple, nous renvoyons une réponse JSON avec un message d'erreur
            return new JsonResponse(['error' => 'Aucun thème ou cours n\'a été sélectionné.']);
        }
    }
}
