<?php

namespace App\Controller\Admin;

use App\Entity\Apartment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ApartmentController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Apartment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Apartment')
            ->setEntityLabelInPlural('Apartments')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('address_1')->hideOnIndex(),
            TextField::new('address_2')->hideOnIndex(),
            TextField::new('village')->hideOnIndex(),
            TextField::new('mandal')->hideOnIndex(),
            TextField::new('city'),
            TextField::new('state')->hideOnIndex(),
            TextField::new('country')->hideOnIndex(),
            TextField::new('pincode'),
            TextField::new('contact_number'),
            AssociationField::new('president'),
            AssociationField::new('secretary'),
            AssociationField::new('tresurer'),
            AssociationField::new('security'),
        ];
    }
}
