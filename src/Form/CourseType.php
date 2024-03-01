<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver; 

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('theme', EntityType::class, [
                'class' => Theme::class, // Change the class to Theme::class
                'choice_label' => 'name', // Assurez-vous de remplacer 'name' par le champ approprié pour afficher le nom du thème
                'label' => 'Thème associé', // Label updated to 'Thème associé'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
