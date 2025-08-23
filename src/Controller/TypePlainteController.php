<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TypePlainteController extends AbstractController
{
    #[Route('/type/plainte', name: 'app_type_plainte')]
    public function index(): Response
    {
        return $this->render('type_plainte/index.html.twig', [
            'controller_name' => 'TypePlainteController',
        ]);
    }
}
