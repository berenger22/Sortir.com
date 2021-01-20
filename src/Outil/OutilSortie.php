<?php 

namespace App\Outil;

use DateTime;
use App\Entity\Etat;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;

class OutilSerie
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function gererEtat(Sortie $sortie, EntityManagerInterface $em)
    {
        $dateDebut = $sortie->getDateHeureDebut()->getTimestamp();
        $fin = $dateDebut + ($sortie->getDuree() * 1000 * 60);
        $dateFin = $sortie->getDateLimiteInscription()->getTimestamp();
        $now = (new \DateTime())->getTimestamp();
        $nbreParticipants = count($sortie->getParticipants());

        if($fin < $now && $sortie->getEtat()->getLibelle() != 'Passée'){
            $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Passée']);
            $sortie->setEtat($etat);
        }elseif($dateFin < $now && $sortie->getEtat()->getLibelle() != 'Clôturée'){
            $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Clôturée']);
            $sortie->setEtat($etat);      
        }elseif($nbreParticipants === $sortie->getNbInscriptionsMax() && $sortie->getEtat()->getLibelle() != 'Clôturée'){
            $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Clôturée']);
            $sortie->setEtat($etat);
        }elseif(($dateDebut < $now && $fin > $now) && $sortie->getEtat()->getLibelle() != 'Activitée en cours'){
            $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Activitée en cours']);
            $sortie->setEtat($etat);
        }
        $em->persist($sortie);
        $em->flush();
    }
}