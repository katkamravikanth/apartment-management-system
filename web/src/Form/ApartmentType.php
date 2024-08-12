<?php

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\Building;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ApartmentType extends AbstractType
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
                'label' => 'Address',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control']
            ])
            ->add('size', IntegerType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => 'Size',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control']
            ])
            ->add('rentAmount', MoneyType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'divisor' => 100,
                'label' => 'Rent Amount',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control']
            ])
            ->add('building', EntityType::class, [
                'class' => Building::class,
                'choice_label' => 'name',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control']
            ])
            ->add('owner', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Apartment::class,
        ]);
    }
}
