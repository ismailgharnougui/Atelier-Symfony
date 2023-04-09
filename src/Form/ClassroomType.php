<?php

namespace App\Form;

use App\Entity\Classroom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassroomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Nom Classroom',
                'attr'=>[
                    'placeholder'=>'Merci de définir le nom',
                    'class'=>'name'
                ]
            ])                            //<input type=text>
            ->add('nbetudiant',IntegerType::class,[
                'label'=>'Nb Etudiant',
                'attr'=>[
        'placeholder'=>'Merci de définir le nombre des etudiants',
        'class'=>'nbetudiant'
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classroom::class,
        ]);
    }
}
