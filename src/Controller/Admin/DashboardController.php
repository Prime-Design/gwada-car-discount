<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        // Seul le Super Admin peut accéder au dashboard
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->render('admin/dashboard.html.twig');
        }

        // Redirige les autres utilisateurs
        return $this->redirectToRoute('app_post');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle("Gwada Car Discount - Admin");
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour au site', 'fa-solid fa-arrow-left', 'app_post');

        // Menu réservé uniquement au Super Admin
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
            yield MenuItem::section('Gestion des Utilisateurs');
            yield MenuItem::linkToCrud('Liste des Utilisateurs', 'fas fa-users', User::class);
            yield MenuItem::section('Gestion des Articles');
            yield MenuItem::linkToCrud('Tous les Articles', 'fas fa-newspaper', Post::class);
            yield MenuItem::linkToCrud('Creer un article', 'fas fa-newspaper', Post::class)->setAction(Crud::PAGE_NEW);

        }
    }

 
    
}
