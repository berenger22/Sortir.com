<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo :',
                'attr' => [
                    'maxlength' => 30
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom :',
                'attr' => [
                    'maxlength' => 30
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom :',
                'attr' => [
                    'maxlength' => 30
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone :',
                'required' => false,
                'attr' => [
                    'maxlength' => 10
                ]
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Mail :',
                'attr' => [
                    'maxlength' => 50
                ]
            ] ) 
            ->add('password', PasswordType::class, [
                'label' => 'Nouveau mot de passe :',
                'attr' => [
                    'maxlength' => 20
                ]
            ])
            ->add('verifPassword', PasswordType::class, [
                'label' => 'Confirmation mot de passe :',
                'attr' => [
                    'maxlength' => 20
                ]
            ])
            ->add('campus', EntityType::class,[
                'class' => Campus::class,
                'choice_label' => 'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
            'translation_domain' => 'forms'
        ]);
    }
}
