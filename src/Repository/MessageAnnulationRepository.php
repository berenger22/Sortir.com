<?php

namespace App\Repository;

use App\Entity\MessageAnnulation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MessageAnnulation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageAnnulation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageAnnulation[]    findAll()
 * @method MessageAnnulation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageAnnulationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageAnnulation::class);
    }

    // /**
    //  * @return MessageAnnulation[] Returns an array of MessageAnnulation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessageAnnulation
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
