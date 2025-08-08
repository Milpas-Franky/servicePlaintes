<?php

namespace App\DataFixtures;

use App\Entity\Reponse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReponseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Récupération des entités associées via les références
        $user = $this->getReference('user_default');
        $plainte = $this->getReference('plainte_default');

        $reponse = new Reponse();
        $reponse->setContenu("Nous avons bein reçu votre plainte. Nous vous tenons au courant le plus tôt possible.");
        $reponse->setDate(new \DateTime());
        $reponse->setUser($user);
        $reponse->setPlainte($plainte);

        $manager->persist($reponse);
        $manager->flush();

        //$this->addReference('reponse_default', $reponse);
    }


    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            PlainteFixtures::class,
        ];
    }
}
