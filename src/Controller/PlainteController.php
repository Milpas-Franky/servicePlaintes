<?php

namespace App\Controller;

use App\Entity\Plainte;
use App\Form\PlainteType;
use App\Entity\Status;
use App\Repository\PlainteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class PlainteController extends AbstractController
{
    #[Route('/plainte', name: 'app_plainte_index')]
    public function index(PlainteRepository $plainteRepository): Response
    {
        $plaintes = $plainteRepository->findAll();

        return $this->render('plainte/index.html.twig', [
            //'controller_name' => 'PlainteController',
            'plaintes' => $plaintes,
            'resource' => 'plaintes',
        ]);
    }

    #[Route('/new', name: 'app_plainte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $plainte = new Plainte();
        $form = $this->createForm(PlainteType::class, $plainte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($plainte);
            $entityManager->flush();
            return $this->redirectToRoute('app_plainte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('plainte/new.html.twig', [
            'commentaire' => $plainte,
            'form' => $form,
        ]);
    }

    #[Route('/plainte/{id}', name: 'app_plainte_show', methods: ['GET'])]
    public function show(Plainte $plainte): Response
    {
        return $this->render('plainte/show.html.twig', ['plainte' => $plainte,]);
    }

    #[Route('/plainte/{id}/edit', name: 'app_plainte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Plainte $plainte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlainteType::class, $plainte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_plainte_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('plainte/edit.html.twig', ['plainte' => $plainte, 'form' => $form,]);
    }

    #[Route('plainte/{id}', name: 'app_plainte_delete', methods: ['POST'])]
    public function delete(Request $request, Plainte $plainte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid(
            'delete' . $plainte->getId(),
            $request->request->get('_token')
        )) {
            $entityManager->remove($plainte);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_plainte_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/deposer-plainte', name: 'app_deposer_plainte')]
    #[IsGranted('ROLE_USER')]
    public function deposer(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $plainte = new Plainte();

        // Génération automatique
        $plainte->setCodeSuivi(uniqid('PLN-'));
        $plainte->setDateCreation(new \DateTime());

        // Création du formulaire
        $form = $this->createForm(PlainteType::class, $plainte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Lier l'utilisateur connecté
            $plainte->setUser($this->getUser());

            if (!$this->getUser()) {
                throw $this->createAccessDeniedException('Vous devez être connecté pour déposer une plainte.');
            }

            // Définition du statut initial
            $status = $em->getRepository(Status::class)->findOneBy(['nom' => 'En attente']);
            $plainte->setStatus($status);

            $em->persist($plainte);
            $em->flush();

            $email = (new Email())
                ->from('noreply@regideso.com')
                ->to($plainte->getUser()->getEmail())
                ->subject('Confirmation de votre plainte')
                ->html('<p>Bonjour ' . $plainte->getUser()->getNom() . ',<br><br>
                Votre plainte a été enregistrée avec succès.<br>
                Code de suivi : <strong>' . $plainte->getCodeSuivi() . '</strong><br><br>
                Nous vous tiendrons informé de son évolution.<br><br>
                Merci pour votre confiance.</p>');

            $mailer->send($email);

            $this->addFlash('success', 'Votre plainte a été enregistrée. Un email de confirmation vous a été envoyé.');

            // return $this->redirectToRoute('app_deposer_plainte');
            return $this->redirectToRoute('app_user_dashboard');
        }

        $this->addFlash('success', 'Votre plainte a été enregistrée. Code de suivi : ' . $plainte->getCodeSuivi());

        // return $this->redirectToRoute('app_user_dashboard'); 


        return $this->render('user/deposer_plainte.html.twig', [
            // return $this->render('plainte/deposer_plainte.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/suivre-plainte', name: 'app_suivre_plainte')]
    #[Route('', name: 'suivre_plainte_form', methods: ['GET', 'POST'])]
    public function suivre(Request $request, PlainteRepository $repository): Response
    {
        $code = $request->request->get('code_suivi');
        $plainte = $code ? $repository->findOneBy(['codeSuivi' => $code]) : null;

        // Lier l'utilisateur connecté
        //$plainte->setUser($this->getUser());

        if (!$this->getUser()) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour suivre une plainte.');
        }

        return $this->render(
            'plainte/suivi.html.twig',
            [
                //'controller_name' => 'SuiviPlainteController', 
                'plainte' => $plainte,
                'code' => $code,
            ]
        );
    }

    #[Route('/mes-plaintes', name: 'app_user_plaintes')]
    public function mesPlaintes(PlainteRepository $repo): Response
    {
        $user = $this->getUser();
        $plaintes = $repo->findBy(['user' => $user]);

        return $this->render('user/plaintes.html.twig', [
            'plaintes' => $plaintes,
        ]);
    }
}
