<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Ville;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LieuVilleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $ville1 = new Ville();
        $ville1->setNom('Saint Herblain')
                ->setCodePostal('44800');
        $manager->persist($ville1);

        $ville2 = new Ville();
        $ville2->setNom('Quimper')
                ->setCodePostal('29100');
        $manager->persist($ville2);

        $ville3 = new Ville();
        $ville3->setNom('Chartres de bretagne')
                ->setCodePostal('35820');
        $manager->persist($ville3);

        $ville4 = new Ville();
        $ville4->setNom('La mézière')
                ->setCodePostal('35520');
        $manager->persist($ville4);

        
        $lieu1 = new Lieu();
        $lieu1->setNom('Mega CGR')
                ->setRue('Zone de Millet')
                ->setVille($ville4)
                ->setLatitude(48.2465)
                ->setLongitude(-1.725);
        $manager->persist($lieu1);

        $lieu2 = new Lieu();
        $lieu2->setNom('Piscine')
                ->setRue('2 Rue Léo Lagrange')
                ->setVille($ville3)
                ->setLatitude(48.0400925)
                ->setLongitude(-1.692255);
        $manager->persist($lieu2);

        $lieu3 = new Lieu();
        $lieu3->setNom('Zénith')
                ->setRue('Boulevard du Zénith')
                ->setVille($ville1)
                ->setLatitude(47.2176)
                ->setLongitude(-1.6484);
        $manager->persist($lieu3);

        $manager->flush();
    }
}
