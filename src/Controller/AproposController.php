<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AproposController extends AbstractController
{
    #[Route('/a-propos', name: 'app_apropos')]
    public function about(): Response
    {
        return $this->render('static/about.html.twig', [
            //'controller_name' => 'AproposController',
        ]);
    }
}
