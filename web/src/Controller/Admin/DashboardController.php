<?php

namespace App\Controller\Admin;

use App\Entity\Announcement;
use App\Entity\Apartment;
use App\Entity\Configuration;
use App\Entity\Flat;
use App\Entity\Transaction;
use App\Entity\TransactionType;
use App\Entity\User;
use App\Entity\UserFlatHistory;
use App\Entity\UserType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('AMS')
            ->generateRelativeUrls();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linktoRoute('Back to the website', 'fa fa-backward', 'homepage');
        yield MenuItem::linkToCrud('User Types', 'fa fa-users', UserType::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Apartments', 'fa fa-building', Apartment::class);
        yield MenuItem::linkToCrud('Flats', 'fa fa-house-user', Flat::class);
        yield MenuItem::linkToCrud('Transaction Types', 'fa fa-globe', TransactionType::class);
        yield MenuItem::linkToCrud('Transactions', 'fa fa-money-bill-transfer', Transaction::class);
        yield MenuItem::linkToCrud('User Flat History', 'fa fa-clock-rotate-left', UserFlatHistory::class);
        yield MenuItem::linkToCrud('Configuration', 'fa fa-gear', Configuration::class);
        yield MenuItem::linkToCrud('Announcement', 'fa fa-bullhorn', Announcement::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
