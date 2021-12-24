<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        if($options['isEdit']) {
            $builder
                ->add('fullName', TextType::class,[
                    'label' => "Nom complet",
                    'attr' => [
                        'placeholder' => 'Votre nom complet'
                    ],
                    "required" => true
                ])
                ->add("address", TextareaType::class, [
                    'label' => "Votre addresse de livraison",
                    'attr' => [
                        'placeholder' => 'Renseigner votre adresse de livraison'
                    ],
                    "required" => true
                ])
                ->add('submit', SubmitType::class, [
                    'label' => "Modifier"
                ]);
        } else {
            $builder
                ->add('email', EmailType::class, [
                    'label' => "Email",
                    'required' => true
                ])
                ->add('password', RepeatedType::class, [
                    'label' => 'Mot de passe',
                    'type' => PasswordType::class,
                    'required' => true,
                    'invalid_message' => 'les mot de passe ne sont pas identique',
                    'first_options' => array(
                        'label' => 'Mot de passe',
                        'attr' => [
                            'placeholder' => '*****',
                        ],
                    ),
                    'second_options' => array(
                        'label' => 'Comfirmez votre mot de passe',
                        'attr' => [
                            'placeholder' => '*****'
                        ],
                    ),
                ])
                ->add('submit', SubmitType::class, [
                    'label' => "Inscription"
                ])
            ;
        }





    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isEdit' => false,
        ]);
    }
}
