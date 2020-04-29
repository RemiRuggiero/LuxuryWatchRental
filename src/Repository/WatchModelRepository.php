<?php

namespace App\Repository;

use App\Entity\WatchModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WatchModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method WatchModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method WatchModel[]    findAll()
 * @method WatchModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WatchModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WatchModel::class);
    }

    /* public function findByGenderMale( $genderMale ): ?WatchModel
    {
        $stmt = $this->createQueryBuilder( 'e' );
        $stmt->where( 'e.gender = :1' );
        $stmt->setParameter( 0, $genderMale );

        return $stmt->getQuery()->getResult();
    } */

    /**
      * @return WatchModel[] Returns an array of WatchModel objects
     */
    
    public function findByGender($gendermale)
    {
        return $this->createQueryBuilder('w')
            ->select('w')
            /* ->from("App\Entity\WatchModel", 'w') */
            ->where('w.gender = :gender OR w.gender = 2')
            ->setParameter('gender', $gendermale)
            ->getQuery()
            ->getResult()
        
        ;
    }


    // /**
    //  * @return WatchModel[] Returns an array of WatchModel objects
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
    public function findOneBySomeField($value): ?WatchModel
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
