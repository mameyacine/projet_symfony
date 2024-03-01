<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\Extension\Core\Type\FileType; // Importer FileType
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class LessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('course', EntityType::class, [ // Ajouter un champ EntityType pour sélectionner le cours
            //     'class' => Course::class,
            //     'label' => 'Course',
            //     'required' => true,
            // ])
            ->add('name')
            ->add('file', FileType::class, [
                'label' => 'Lesson File',
                'mapped' => false,
            ]);
            

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
