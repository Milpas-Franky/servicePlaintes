<?php

namespace App\DataFixtures;


use App\Entity\Plainte;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PlainteFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Récupération des entités associées via les références
        $user = $this->getReference('user_default');
        $commune = $this->getReference('commune_default');
        $status = $this->getReference('status_default');
        $type = $this->getReference('type_default');


        // Création d'une plainte
        for ($i = 0; $i < 5; $i++) {
            $plainte = new Plainte();
            $plainte->setObjet('Fuite d’eau au niveau du compteur');
            $plainte->setDescription('Une fuite est visible à la base du compteur de l’abonné.');
            $plainte->setDateCreation(new \DateTime());
            $plainte->setCodeSuivi(uniqid('PLN-'));
            $plainte->setUser($user);
            $plainte->setTypePlainte($type);
            $plainte->setStatus($status);
            $plainte->setCommune($commune);
        }


        $manager->persist($plainte);

        $this->addReference('plainte_default', $plainte);

        $manager->flush();


        // Référence utile pour commentaire/réponse fixtures
        echo "✅ Plainte insérée avec succès.\n";
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CommuneFixtures::class,
            TypePlainteFixtures::class,
            StatusFixtures::class,

        ];
    }
}
