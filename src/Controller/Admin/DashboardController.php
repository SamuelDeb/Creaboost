<?php

namespace App\Controller\Admin;

use App\Entity\Sujets;
use App\Entity\Membres;
use App\Entity\Messages;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Creaboost');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Creaboost');
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'app_accueil');
    
        yield MenuItem::subMenu('Membres', 'fas fa-list', Membres::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Membres::class) 
                            ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Membres::class)
            ]);
            
        
        yield MenuItem::subMenu('Sujets', 'fas fa-list', Sujets::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Sujets::class) 
                            ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Sujets::class)
            ]);
        
        yield MenuItem::subMenu('Messages', 'fas fa-list', Messages::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Messages::class) 
                            ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Messages::class)
            ]);
    }
}
