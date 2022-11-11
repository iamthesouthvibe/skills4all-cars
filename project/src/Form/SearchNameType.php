<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\CarCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class SearchNameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Name',
                ],
                
            ])
            ->add('Register', SubmitType::class, ['attr' => ['class' => 'btn btn-primary']])
            ->add('carCategory', EntityType::class, [
                'class' => CarCategory::class,
                'required' => false,
                'placeholder' => 'Choose an option',
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control',
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
