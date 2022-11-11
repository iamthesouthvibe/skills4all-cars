<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\CarCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CarFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('cost', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('nbDoors',  ChoiceType::class, [
                'choices'  => [
                    '4' => 4,
                    '5' => 5,
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
                ])
            ->add('nbSeats', ChoiceType::class, [
                'choices'  => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 8,
                    '9' => 9,
                ],
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('carCategory', EntityType::class, [
                'class' => CarCategory::class,
                'required' => false,
                'placeholder' => 'Choose an option',
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('save', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
