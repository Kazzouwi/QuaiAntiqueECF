<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Meal;
use App\Repository\IngredientRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du repas',
            ])
            ->add('isFavorite')
            ->add('image', FileType::class, array('data_class' => null))
            ->add('image', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*'
                        ],
                        'mimeTypesMessage' => 'L\'image n\'est pas au bon format',
                    ])
                ]
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true
            ])
            ->add('mealCategory', ChoiceType::class, [
                'choices' => [
                    'Entrée' => 'starter',
                    'Plat' => 'dish',
                    'Dessert' => 'dessert'
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
            ])
        ;




    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
        ]);
    }
}
