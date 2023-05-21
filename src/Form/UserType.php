<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('guests')
            ->add('allergen', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function ($repository) {
                    return $repository->createQueryBuilder('i')
                        ->andWhere('i.isAllergen = :isAllergen')
                        ->setParameter('isAllergen', true);
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
