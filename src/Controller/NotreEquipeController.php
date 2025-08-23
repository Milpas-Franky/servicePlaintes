<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NotreEquipeController extends AbstractController
{
    #[Route('/notre-equipe', name: 'app_team')]
    public function team(): Response
    {
        return $this->render('static/team.html.twig');
        //'controller_name' => 'NotreEquipeController'
    }
}
