<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Campus;
use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'maxlength' => 50
                ]
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'years' => range(2021,2030),
                'widget' => 'single_text',
                'html5' => 'true'
            ])
            ->add('duree', IntegerType::class)
            ->add('dateLimiteInscription', DateTimeType::class, [
                'years' => range(2021,2030),
                'widget' => 'single_text',
                'html5' => 'true'
            ])
            ->add('nbInscriptionsMax', IntegerType::class, [
                'attr' => [
                    'min' => '1',
                    'max' => '100'
                ]
            ])
            ->add('infosSortie', TextareaType::class, [
                'required' => 'false',
                'attr' => [
                    'maxlength' => 255
                ]
            ])
            ->add('campus', EntityType::class,[
                'class' => Campus::class,
                'choice_label' => 'nom'
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom'
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-lg btn-outline-primary btn-block'
                ]
            ])
            ->add('publier', SubmitType::class, [
                'label' => 'Publier la sortie',
                'attr' => [
                    'class' => 'btn btn-lg btn-outline-success btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
            'translation_domain' => 'forms'
        ]);
    }
}
