<?php

namespace App\Repository;

use App\Entity\BikeSale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BikeSale>
 *
 * @method BikeSale|null find($id, $lockMode = null, $lockVersion = null)
 * @method BikeSale|null findOneBy(array $criteria, array $orderBy = null)
 * @method BikeSale[]    findAll()
 * @method BikeSale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BikeSaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BikeSale::class);
    }

//    /**
//     * @return BikeSale[] Returns an array of BikeSale objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BikeSale
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
