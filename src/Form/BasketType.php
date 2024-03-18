<?php

namespace App\Form;

use App\Entity\Basket;
use App\Entity\Category;
use App\Entity\Couleur;
use App\Entity\Taille;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class BasketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('sous_titre')
            ->add('description')
            ->add('photo',FileType::class, [
                'label' => 'Première vue de la paire de chaussure',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        //'maxSize' => '200k',
                        //'mimeTypes' => ['image/png' , 'image/jpeg'],
                        'mimeTypesMessage' => 'Sélectionnez un fichier PNG de poids inférieur à 200Ko',
                        ])
                    ]
            ])
            ->add('photo2',FileType::class, [
                'label' => 'Deuxième vue de la paire de chaussure',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        //'maxSize' => '200k',
                        //'mimeTypes' => ['image/png'],
                        'mimeTypesMessage' => 'Sélectionnez un fichier PNG de poids inférieur à 200Ko',
                    ])
                ]
            ])
            ->add('photo3',FileType::class, [
                'label' => 'Troisième vue de la paire de chaussure',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        //'maxSize' => '200k',
                        //'mimeTypes' => ['image/png'],
                        'mimeTypesMessage' => 'Sélectionnez un fichier PNG de poids inférieur à 200Ko',
                    ])
                ]
            ])
            ->add('photo4',FileType::class, [
                'label' => 'Quatrième vue de la paire de chaussure',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        //'maxSize' => '200k',
                        //'mimeTypes' => ['image/png'],
                        'mimeTypesMessage' => 'Sélectionnez un fichier PNG de poids inférieur à 200Ko',
                    ])
                ]
            ])
            ->add('prix')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'type',
            ])
            ->add('couleurs', EntityType::class, [
                'class' => Couleur::class,
                'choice_label' => 'color',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('tailles', EntityType::class, [
                'class' => Taille::class,
                'choice_label' => 'taille',
                'expanded' => true,
                'multiple' => true,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Basket::class,
        ]);
    }
}
