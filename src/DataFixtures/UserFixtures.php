<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création des rôles
        $adminRole = new Role();
        $adminRole->setNom(('ROLE_ADMIN'));
        $manager->persist($adminRole);

        $agentRole = new Role();
        $agentRole->setNom(('ROLE_AGENT'));
        $manager->persist($agentRole);

        $abonneRole = new Role();
        $abonneRole->setNom(('ROLE_ABONNE'));
        $manager->persist($abonneRole);


        // Création de l'utilisateur Admin
        $admin = new User();
        $admin->setNom('Luzayangamo')
            ->setPostnom('Mampuya')
            ->setPrenom('Nourdine')
            ->setEmail('admin@eau.com')
            ->setTelephone('+243 852 675 684')
            ->setPassword($this->hasher->hashPassword($admin, 'admin123'))
            ->setRoles(['ROLE_ADMIN'])
            ->setRole($adminRole);

        $manager->persist($admin);
        $this->addReference('admin_user', $admin);


        // Création d'un agent
        $agent = new User();
        $agent->setNom('Luzayangamo')
            ->setPostnom('Anna')
            ->setPrenom('Aminata')
            ->setEmail('agent@eau.com')
            ->setTelephone('+243 816 015 211')
            ->setPassword($this->hasher->hashPassword($agent, 'agent123'))
            ->setRoles(['ROLE_AGENT'])
            ->setRole($agentRole);

        $manager->persist($agent);
        $this->addReference('agent_user', $agent);


        // Création d'un abonné
        $abonne = new User();
        $abonne->setNom('Kongolo')
            ->setPostnom('Mbumba')
            ->setPrenom('Frank')
            ->setEmail('abonne@eau.com')
            ->setTelephone('+243 816 015 211')
            ->setPassword($this->hasher->hashPassword($abonne, 'abonne123'))
            ->setRoles(['ROLE_ABONNE'])
            ->setRole($abonneRole);

        $manager->persist($abonne);
        $this->addReference('abonne_user', $abonne);


        // Création de User par défaut (pour les fixtures)
        $user = new User();
        $user->setNom('User')
            ->setPostnom('Démo')
            ->setPrenom('Fixture')
            ->setEmail('user@eau.com')
            ->setTelephone('+243000000000')
            ->setPassword($this->hasher->hashPassword($user, 'user123'))
            ->setRoles(['ROLE_ABONNE'])
            ->setRole($abonneRole);

        $manager->persist($user);
        $this->addReference('user_default', $user);

        $manager->flush();
    }
}
