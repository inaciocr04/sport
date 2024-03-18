<?php

namespace App\Form;

use App\Entity\Basket;
use App\Entity\Couleur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CouleurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('color')
            /*->add('basket', EntityType::class, [
                'class' => Basket::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Couleur::class,
        ]);
    }
}
