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

        if($dateFin < $now){
            $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Clôturée']);
            $sortie->setEtat($etat);
        }elseif($nbreParticipants === $sortie->getNbInscriptionsMax() ){
            $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Clôturée']);
            $sortie->setEtat($etat);
        }elseif($dateDebut < $now && $fin > $now){
            $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Activitée en cours']);
            $sortie->setEtat($etat);
        }elseif($fin > $now){
            $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Passée']);
            $sortie->setEtat($etat);
        }else { 
            $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
            $sortie->setEtat($etat);
        }
        $em->persist($sortie);
        $em->flush();
    }
}