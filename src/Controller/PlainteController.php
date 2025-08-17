<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlainteController extends AbstractController
{
    #[Route('/plainte', name: 'app_plainte')]
    public function index(): Response
    {
        return $this->render('plainte/index.html.twig', [
            'controller_name' => 'PlainteController',
        ]);
    }
}
