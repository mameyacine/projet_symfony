<?php
namespace App\Form;

use App\Entity\QCM;
use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class QCMType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du QCM',
            ])
            ->add('course', EntityType::class, [
                'class' => Course::class,
                'choice_label' => 'name', // Assurez-vous de remplacer 'name' par le champ approprié pour afficher le nom du cours
                'label' => 'Cours associé', 
            ]);

            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QCM::class,
        ]);
    }
}
