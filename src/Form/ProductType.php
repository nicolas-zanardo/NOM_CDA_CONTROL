<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom du produit",
                "required" => true
            ])
            ->add('price', MoneyType::class, [
                "label" => "Prix du produit",
                "required" => true,
            ])
            ->add('img', FileType::class, [
                "required" => false,
                "constraints" => [
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => "Extension autorisées : PNG - JPG - JPEG"
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                "class" => Category::class,
                "choice_label" => "name"
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description produit",
                'attr' => [
                    'placeholder' => 'Renseigner votre adresse de livraison'
                ],
                "required" => true
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Créer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
