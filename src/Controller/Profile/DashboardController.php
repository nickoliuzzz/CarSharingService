<?php

namespace App\Controller\Profile;

use App\Entity\User;
use App\Entity\Friend;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public const PROFILE_PREFIX = '/profile';

    #[Route(self::PROFILE_PREFIX, name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/default-page.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Kilometrage');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Edit profile', 'fas fa-list', Friend::class);
        yield MenuItem::linkToRoute('Download report', 'fas fa-list', FriendCrudController::DOWNLOAD_REPORT_ROUTE);
    }
}
