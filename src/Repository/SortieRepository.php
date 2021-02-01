<?php

namespace App\Repository;

use App\Entity\FiltreSortie;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findAllSorties(FiltreSortie $filtre)
    {
        $query = $this->createQueryBuilder('s')
                    ->leftJoin('s.participants', 'p')
                    ->addSelect('p')
                    ->leftJoin('s.etat', 'e')
                    ->addSelect('e')
                    ->leftJoin('s.campus', 'ca')
                    ->addSelect('ca');
        if($filtre->getCampus()){
            $idCampus = $filtre->getCampus()->getId();
            $query = $query->andWhere("s.campus = :campus")
                            ->setParameter("campus", $idCampus);
        }
        if($filtre->getNomSortie()){
            $nom = $filtre->getNomSortie();
            $query = $query->andWhere("s.nom like :nomSortie")
                            ->setParameter("nomSortie", "%$nom%");
        }
        if($filtre->getDebutDate()){
            $query = $query->andWhere("s.dateHeureDebut >= :debutDate")
                            ->setParameter("debutDate", $filtre->getDebutDate());
        }
        if($filtre->getFinDate()){
            $query = $query->andWhere("s.dateHeureDebut <= :finDate")
                            ->setParameter("finDate", $filtre->getFinDate());
        }
        if($filtre->getSortieOrganisateur()){
            $query = $query->andWhere("s.organise = :organisateur")
                            ->setParameter("organisateur", $filtre->getIdUser());
        }
        if($filtre->getSortieInscrit()){
            $query = $query->andWhere(":inscrit MEMBER OF s.participants")
                            ->setParameter("inscrit", $filtre->getIdUser());
        }
        if($filtre->getSortiePasInscrit()){
            $query = $query->andWhere(":noInscrit NOT MEMBER OF s.participants")
                            ->setParameter("noInscrit", $filtre->getIdUser());
        }
        if($filtre->getSortiePassee()){
            $query = $query->andWhere("s.etat = :passee")
                            ->setParameter("passee", "Passée");
        }
        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
