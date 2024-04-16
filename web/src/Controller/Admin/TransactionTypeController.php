<?php

namespace App\Controller\Admin;

use App\Entity\TransactionType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TransactionTypeController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TransactionType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Transaction Type')
            ->setEntityLabelInPlural('Transaction Types')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
        ];
    }
}
