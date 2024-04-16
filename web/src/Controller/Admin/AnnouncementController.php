<?php

namespace App\Controller\Admin;

use App\Entity\Announcement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnnouncementController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Announcement::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Announcement')
            ->setEntityLabelInPlural('Announcements')
            ;
    }

    public function createEntity(string $entityFqcn)
    {
        $announcement = new Announcement();
        $announcement->setUser($this->getUser());

        return $announcement;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('type')->setChoices([
                'Announcement' => 'announcement',
                'Notification' => 'notification',
                'Warning' => 'warning',
            ]),
            TextField::new('title'),
            TextEditorField::new('message'),
            ChoiceField::new('status')->setChoices([
                'Draft' => 'draft',
                'Publish' => 'publish'
            ])
            ->renderExpanded()
            ->allowMultipleChoices(false)
        ];
    }
}
