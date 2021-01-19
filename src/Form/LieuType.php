<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'maxlength' => 50
                ]
            ])
            ->add('rue', TextType::class, [
                'attr' => [
                    'maxlength' => 80
                ]
            ])
            ->add('latitude', IntegerType::class, [
                'required' => 'false',
                'attr' => [
                    'min' => '-1000000',
                    'max' => '1000000'
                ]
            ])
            ->add('longitude', IntegerType::class, [
                'required' => 'false',
                'attr' => [
                    'min' => '-1000000',
                    'max' => '1000000'
                ]
            ])
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
