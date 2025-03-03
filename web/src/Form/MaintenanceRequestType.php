<?php

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\MaintenanceRequest;
use App\Entity\User;
use App\Enum\MaintenanceRequestStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class MaintenanceRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => 'Title',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => 'Description',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control', 'cols' => '150', 'rows' => '10']
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Open' => MaintenanceRequestStatus::OPEN,
                    'In Progress' => MaintenanceRequestStatus::IN_PROGRESS,
                    'Closed' => MaintenanceRequestStatus::CLOSED,
                    'Cancelled' => MaintenanceRequestStatus::CANCELLED,
                ],
                'label' => 'Status',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control']
            ])
            ->add('requester', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control']
            ])
            ->add('apartment', EntityType::class, [
                'class' => Apartment::class,
                'choice_label' => 'name',
                'row_attr' => ['class' => 'form-group'],
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MaintenanceRequest::class,
        ]);
    }
}
