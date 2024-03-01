<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\PostForum;
use App\Entity\User;
use App\Repository\CourseRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PostForumType extends AbstractType
{
    private $tokenStorage;
    private $courseRepository;

    public function __construct(TokenStorageInterface $tokenStorage, CourseRepository $courseRepository)
    {
        $this->tokenStorage = $tokenStorage;
        $this->courseRepository = $courseRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Contenu du message',
                'attr' => ['rows' => 4], // Définir le nombre de lignes pour la zone de texte
            ])

            ->add('course', EntityType::class, [
                'class' => Course::class,
                'label' => 'Cours',
                'choice_label' => 'name', // Le champ de l'entité à afficher dans la liste déroulante
                'choices' => $this->getUserCourses(), // Définir les cours disponibles pour l'utilisateur actuel
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostForum::class,
        ]);
    }

    private function getUserCourses()
    {
        // Récupérer le jeton d'authentification
        $token = $this->tokenStorage->getToken();
        
        // Vérifier si le jeton est valide et récupérer l'utilisateur actuel
        if ($token && $token->getUser() instanceof User) {
            $user = $token->getUser();
            // Récupérer les cours de l'utilisateur actuel depuis la base de données
            return $this->courseRepository->findUserCourses($user);
        }
        
        // Si l'utilisateur n'est pas connecté ou n'est pas un objet User, retourner un tableau vide
        return [];
    }
}
