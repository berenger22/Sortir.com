<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\FiltreSortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class FiltreSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('campus', EntityType::class,[
            'label' => 'Campus : ',
            'required' => false,
            'class' => Campus::class,
            'choice_label' => 'nom'
        ])
        ->add('nomSortie', TextType::class, [
            'label' => 'Le nom de la sortie contient :',
            'required' => false,
            'attr' => [
                'maxlength' => 30
            ]
        ])
        ->add('debutDate', DateTimeType::class, [
            'label' => 'Entre ',
            'years' => range(2021,2030),
            'widget' => 'single_text',
            'html5' => 'true',
            'required' => false,
        ])
        ->add('finDate', DateTimeType::class, [
            'label' => 'et ',
            'years' => range(2021,2030),
            'widget' => 'single_text',
            'html5' => 'true',
            'required' => false,
        ])
        ->add('sortieOrganisateur', CheckboxType::class, [
            'label'    => 'Sorties dont je suis l\'organisteur.trice',
            'required' => false,
            'data' => true, 
        ])
        ->add('sortieInscrit', CheckboxType::class, [
            'label'    => 'Sorties dont je suis inscrit.e',
            'required' => false,
            'data' => true,
        ])
        ->add('sortiePasInscrit', CheckboxType::class, [
            'label'    => 'Sorties dont je ne suis pas incrist.e',
            'required' => false,
            'data' => true,
        ])
        ->add('sortiePassee', CheckboxType::class, [
            'label'    => 'Sorties passées',
            'required' => false,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FiltreSortie::class,
            'method' => 'get',
            'csrf_protection' => false,
            'translation_domain' => 'forms'
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
