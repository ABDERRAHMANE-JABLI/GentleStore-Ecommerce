<?php

namespace App\Controller\Admin;

use App\Entity\Adresse;
use App\Entity\Category;
use App\Entity\Collections;
use App\Entity\OrderDetails;
use App\Entity\Orders;
use App\Entity\Pages;
use App\Entity\Product;
use App\Entity\Settings;
use App\Entity\Sliders;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());

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
            ->setTitle('GentleStore');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('HomePage', 'fas fa-home', $this->generateUrl('app_home'));
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-dashboard');
        yield MenuItem::linkToCrud('Products', 'fas fa-shop', Product::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-tag', Category::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-box-open', Orders::class);
        yield MenuItem::linkToCrud('Detail Order', 'fas fa-sitemap', OrderDetails::class);
        yield MenuItem::linkToCrud('Address', 'fas fa-location', Adresse::class);
        yield MenuItem::linkToCrud('Sliders', 'fas fa-image', Sliders::class);
        yield MenuItem::linkToCrud('Settings', 'fas fa-gear', Settings::class);
        yield MenuItem::linkToCrud('Collections', 'fa fa-sliders', Collections::class);
        yield MenuItem::linkToCrud('WebSite Pages', 'fa fa-file', Pages::class);
        yield MenuItem::linkToCrud('users', 'fas fa-users', User::class);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions(); // toutes les actions qui existent dans cette methode vont etre utilisé par tous les crud controlleur
    }

    /**
     * si je veux desactiver l'action DETAIL pour le crudController user il faut mettre dans le crudController de user : 
     * public function configureActions(): Actions
    {
        return parent::configureActions()->disable(Action::DETAIL); 
    }
     */

}
