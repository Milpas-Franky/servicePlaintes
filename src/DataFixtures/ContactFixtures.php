<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ContactFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = $this->getReference('user_default');

        $contact = new Contact();
        $contact->setEmail('contact@regideso.com');
        $contact->setTelephone('+243899345230');
        $contact->setMessage('Bonjour, je souhaite signaler un problème de pression d’eau.');
        $contact->setDate(new \DateTime());
        $contact->setUser($user);

        $manager->persist($contact);
        $manager->flush();

        echo "✅ Contact fixture inséré.\n";
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
