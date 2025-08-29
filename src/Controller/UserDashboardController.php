<?php

namespace App\Controller;

use App\Entity\Plainte;
use App\Entity\Status;
use App\Form\PlainteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    public function deposerPlainte(Request $request, EntityManagerInterface $em)
    {

        $plainte = new Plainte();

        // Génération automatique
        $plainte->setCodeSuivi(uniqid('PLN-'));
        $plainte->setDateCreation(new \DateTime());

        // Création du formulaire
        $form = $this->createForm(PlainteType::class, $plainte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainte->setDateCreation(new \DateTime());

            // Lier l'utilisateur connecté
            $plainte->setUser($this->getUser());

            if (!$this->getUser()) {
                throw $this->createAccessDeniedException('Vous devez être connecté pour déposer une plainte.');
            }

            // Définition du statut initial
            $status = $em->getRepository(className: Status::class)->findOneBy(['nom' => 'En attente']);
            $plainte->setStatus($status);

            $em->persist($plainte);
            $em->flush();

            $this->addFlash('success', 'Votre plainte a été déposée avec succès.');
            return $this->redirectToRoute('app_user_dashboard');
        }

        return $this->render('user/deposer_plainte.html.twig', [
            'form' => $form->createView(), // ← cette ligne est indispensable
        ]);
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
