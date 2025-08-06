<?php

namespace App\DataFixtures;

use App\Entity\Commune;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class CommuneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $donnees = [
            [
                'commune' => 'Kintambo',
                'rue' => 'Avenue Mobutu 879',
                'quartier' => 'Magasin',
                'ville' => 'Kinshasa',
            ],
            [
                'commune' => 'Lingwala',
                'rue' => 'Avenue des Hirondelles 35',
                'quartier' => 'Beau-Vent',
                'ville' => 'Kinshasa',
            ],
            [
                'commune' => 'Gombe',
                'rue' => 'Boulevard du 30 Juin 1045',
                'quartier' => 'Royal',
                'ville' => 'Kinshasa',
            ],
        ];

        foreach ($donnees as $data) {
            $commune = new Commune();
            $commune->setCommune($data['commune']);
            $commune->setRueEtNumero($data['rue']);
            $commune->setQuartier($data['quartier']);
            $commune->setVille($data['ville']);

            $manager->persist($commune);
        }

        $manager->flush();

        $this->addReference('commune_default', $commune);
    }
}