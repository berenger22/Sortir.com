<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user1 = new Participant();
        $user1->setUsername('toto')
                ->setNom('Redford')
                ->setPrenom('Robert')
                ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$L0FsejBOZzBTNUFlLlNCcw$FRMR0pDuwdZTwi/9PK9zqzBELzn88FjG4BWng7aDGJo')
                ->setMail('robert@redford.fr')
                ->setTelephone('0102030405');
        $manager->persist($user1);

        $user2 = new Participant();
        $user2->setUsername('tata')
                ->setNom('Mathieu')
                ->setPrenom('Mireille')
                ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$L0FsejBOZzBTNUFlLlNCcw$FRMR0pDuwdZTwi/9PK9zqzBELzn88FjG4BWng7aDGJo')
                ->setMail('mireille@mathieu.fr')
                ->setTelephone('0102030405');
        $manager->persist($user2);

        $user3 = new Participant();
        $user3->setUsername('titi')
                ->setNom('Henry')
                ->setPrenom('Thierry')
                ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$YzhaQkFOVDRuMGFNUGVUUQ$GHdNBi6ILcZNfLA66Rr/dhFaS4sq2jTfu3j6UAzmHEo')
                ->setMail('thierry@henry.fr')
                ->setTelephone('0102030405');
        $manager->persist($user3);

        $user4 = new Participant();
        $user4->setUsername('jojo')
                ->setNom('Zarco')
                ->setPrenom('Johann')
                ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$L0FsejBOZzBTNUFlLlNCcw$FRMR0pDuwdZTwi/9PK9zqzBELzn88FjG4BWng7aDGJo')
                ->setMail('johan@zarco.fr')
                ->setTelephone('0987654311');
        $manager->persist($user4);

        $user5 = new Participant();
        $user5->setUsername('lulu')
                ->setNom('Lagrosse')
                ->setPrenom('Lulu')
                ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$L0FsejBOZzBTNUFlLlNCcw$FRMR0pDuwdZTwi/9PK9zqzBELzn88FjG4BWng7aDGJo')
                ->setMail('lulu@lagrosse.fr')
                ->setTelephone('0702030405');
        $manager->persist($user5);

        $manager->flush();
    }
}
