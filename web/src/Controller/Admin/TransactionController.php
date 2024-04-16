<?php

namespace App\Controller\Admin;

use App\Entity\Transaction;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TransactionController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transaction::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Transaction')
            ->setEntityLabelInPlural('Transactions')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('transaction_type'),
            AssociationField::new('payer')->setColumns(6),
            AssociationField::new('payee')->setColumns(6),
            TextField::new('transaction_id')->setColumns(3),
            MoneyField::new('amount')->setCurrency('INR')->setColumns(3),
            ChoiceField::new('mode')->setChoices([
                'UPI' => 'upi',
                'Bank Transfer' => 'bank',
                'Cash' => 'cash',
            ])->setColumns(3),
            TextEditorField::new('description')->hideOnIndex(),
        ];
    }
}
