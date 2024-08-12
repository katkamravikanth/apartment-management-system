<?php

namespace App\Form;

use App\Entity\Building;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class BuildingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => 'Name',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control']
            ])
            ->add('address', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => 'Name',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control']
            ])
            ->add('numOfFloors', IntegerType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => 'No of Floors',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Building::class,
        ]);
    }
}
