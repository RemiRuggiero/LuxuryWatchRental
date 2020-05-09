<?php

namespace App\Repository;

use App\Entity\WatchEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WatchEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method WatchEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method WatchEntity[]    findAll()
 * @method WatchEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WatchEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WatchEntity::class);
    }

    public function findByAvailable($id)
    {
        $stmt = $this->createQueryBuilder('w');
        $stmt->where('w.id = :id')->andWhere('w.available IS NOT NULL');
        $stmt->setParameter('id', $id);
        $stmt->setMaxResults(1);
        if($stmt->getQuery()->getSingleResult()){
            return $stmt->getQuery()->getSingleResult();
        }
        else{
            return 'not ok';
        }
        
    }

    // /**
    //  * @return WatchEntity[] Returns an array of WatchEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WatchEntity
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
