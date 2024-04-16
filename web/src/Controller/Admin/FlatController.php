<?php

namespace App\Controller\Admin;

use App\Entity\Flat;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FlatController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Flat::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Flat')
            ->setEntityLabelInPlural('Flats')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('apartment')->setColumns(6),
            AssociationField::new('owner')->setColumns(6)
                ->setFormTypeOptions([
                    'query_builder' => function (UserRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->leftJoin('u.user_type', 't')
                            ->where('t.name = :type')
                            ->setParameter('type', "Owner");
                    },
                ]),
            TextField::new('flat_number')->setColumns(3),
            TextField::new('floor')->setColumns(3),
            IntegerField::new('rooms')->setColumns(3)->hideOnIndex(),
            IntegerField::new('baths')->setColumns(3)->hideOnIndex(),
            IntegerField::new('balcony')->setColumns(3)->hideOnIndex(),
            IntegerField::new('flat_sft')->setColumns(3),
            ChoiceField::new('furnished_type')->setChoices([
                'Fully Furnished' => 'full',
                'Semi Furnished' => 'semi',
                'None Furnished' => 'none',
            ])->setColumns(3),
            ChoiceField::new('flat_facing')->setChoices([
                'East' => 'east',
                'West' => 'west',
                'North' => 'north',
                'South' => 'soft',
            ])->setColumns(3),
            TextField::new('water_connections')->setColumns(3)->hideOnIndex(),
            TextField::new('gas_connections')->setColumns(3)->hideOnIndex(),
            MoneyField::new('rent')->setCurrency('INR')->setColumns(3)->hideOnIndex(),
            MoneyField::new('maintenance_fee')->setCurrency('INR')->setColumns(3)->hideOnIndex(),
            ChoiceField::new('status')->setChoices([
                'Rented' => 'rented',
                'Self Occupied' => 'self',
            ])->setColumns(3),
        ];
    }
}
