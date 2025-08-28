<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServicesController extends AbstractController
{
    #[Route('/services', name: 'app_services')]
    public function index(): Response
    {
         $services = [
        ['title' => 'Assistance', 'description' => 'Support personnalisé', 'icon' => 'bi bi-chat-dots', 'color' => 'cyan'],
        ['title' => 'Sécurité', 'description' => 'Protection des données', 'icon' => 'bi bi-shield-lock', 'color' => 'red'],
        ['title' => 'Confidentialité', 'description' => 'Respect à la vie privée', 'icon' => 'bi bi-shield-lock', 'color' => 'red'],
        ['title' => 'Astuces et Conseils', 'description' => 'Protection des données', 'icon' => 'bi bi-shield-lock', 'color' => 'red'],
        ['title' => 'Contrôle qualité', 'description' => 'Analyse et contrôle', 'icon' => 'bi bi-shield-lock', 'color' => 'red'],
        
    ];

        return $this->render('services/services.html.twig', ['services' => $services]);   
    }
}