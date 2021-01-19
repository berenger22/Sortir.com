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

        $lieu4 = new Lieu();
        $lieu4->setNom('Bar de la paix')
                ->setRue('Rue de la soif')
                ->setVille($ville2)
                ->setLatitude(47.326)
                ->setLongitude(-1.6454);
        $manager->persist($lieu4);

        $lieu5 = new Lieu();
        $lieu5->setNom('Terrain de basket')
                ->setRue('Rue du sport')
                ->setVille($ville2)
                ->setLatitude(47.2176)
                ->setLongitude(-1.6484);
        $manager->persist($lieu5);

        $lieu6 = new Lieu();
        $lieu6->setNom('Arcade')
                ->setRue('Boulevard du Gamer')
                ->setVille($ville2)
                ->setLatitude(37.2176)
                ->setLongitude(2.6484);
        $manager->persist($lieu6);

        $lieu7 = new Lieu();
        $lieu7->setNom('E.N.I.')
                ->setRue('Impasse ENI')
                ->setVille($ville1)
                ->setLatitude(46.2276)
                ->setLongitude(-1.6484);
        $manager->persist($lieu7);

        $manager->flush();
    }
}
