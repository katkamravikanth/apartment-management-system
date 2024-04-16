<?php

namespace App\Controller\Admin;

use App\Entity\UserFlatHistory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class UserFlatHistoryController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserFlatHistory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('User Flat History')
            ->setEntityLabelInPlural('User Flat Histories')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user')->setColumns(6),
            AssociationField::new('flat')->setColumns(6),
            DateField::new('from_date')->setColumns(3),
            DateField::new('to_date')->setColumns(3),
        ];
    }
}
