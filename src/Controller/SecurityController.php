<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_security_login', methods :['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_security_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    
    #[Route(path: '/inscription', name: 'app_security_registration', methods : ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            //$user = $form->getData();

            
            $em->persist($user);
            $em->flush();

            $email = (new Email())
            ->from('noreply@regideso.com')
            ->to($user->getEmail())
            ->subject('Bienvenue sur notre plateforme')
            ->html('<p>Bonjour ' . $user->getPrenom() . ',<br><br>
                Votre compte a été créé avec succès.<br>
                Vous pouvez maintenant vous connecter et suivre vos plaintes.<br><br>
                Merci pour votre confiance.</p>');

            $mailer->send($email);

            $this->addFlash('success','Votre compte a bien été créé.');
            return $this->redirectToRoute('app_security_login');
        }
            return $this->render('security/register.html.twig', [
                 'form' => $form->createView(),
            ]);
    }
}