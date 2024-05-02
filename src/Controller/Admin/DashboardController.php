<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\OrderDetails;
use App\Entity\Orders;
use App\Entity\Products;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        
        $url = $this->adminUrlGenerator->setController(UserCrudController::class)->generateUrl();
        return $this->redirect($url);

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
            ->setTitle('Innovaelectra');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::section('Utilisateurs'),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),

            MenuItem::section('Commerce'),
            MenuItem::linkToCrud('Categories', 'fa fa-tags', Categories::class),
            MenuItem::linkToCrud('Produits', 'fab fa-product-hunt', Products::class),
            MenuItem::linkToCrud('Commandes', 'fas fa-box', Orders::class),
            MenuItem::linkToCrud('Détails de commande', 'fas fa-boxes', OrderDetails::class),
            MenuItem::section('Retour sur le site'),
            MenuItem::linkToRoute('Accueil du site', 'fa fa-igloo', 'home')
            
        ];
    }
}
