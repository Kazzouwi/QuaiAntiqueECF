<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe'
            ])
            ->add('guests', IntegerType::class, [
                'label' => 'Convives'
            ])
            ->add('allergen', EntityType::class, [
                'class' => Ingredient::class,
                'label' => 'Etes-vous allergique ? Cochez ci-dessous :',
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
