<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class UserDashboardController extends AbstractController
{
    #[Route('/espace-abonne', name: 'app_user_dashboard')]
    #[IsGranted('ROLE_USER')]

    public function index(): Response
    {
        return $this->render('user/dashboard.html.twig');
    }

    #[Route('/deposer-plainte', name: 'app_deposer_plainte')]
    #[IsGranted('ROLE_USER')]
    public function deposerPlainte(): Response
    {
        return $this->render('user/deposer_plainte.html.twig');
    }

    #[Route('/suivre-plainte', name: 'app_suivre_plainte')]
    #[IsGranted('ROLE_USER')]
    public function suivrePlainte(): Response
    {
        return $this->render('user/suivre_plainte.html.twig');
    }

    #[Route('/modifier-infos', name: 'app_modifier_infos')]
    #[IsGranted('ROLE_USER')]
    public function modifierInfos(): Response
    {
        return $this->render('user/modifier_infos.html.twig');
    }
}