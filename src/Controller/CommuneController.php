<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CommuneController extends AbstractController
{
    #[Route('/commune', name: 'app_commune')]
    public function index(): Response
    {
        return $this->render('commune/index.html.twig', [
            'controller_name' => 'CommuneController',
        ]);
    }
}
