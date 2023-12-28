<?php

namespace App\Repository;

use App\Entity\BikeSale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
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

    /**
     * @return array{'score': float, 'asset_number': string, 'ada_price': float }[]
     */
    public function getBestDealsByScore(): array
    {
        $rsm = new ResultSetMapping();
        $rsm
            ->addScalarResult('score', 'score')
            ->addScalarResult('asset_number', 'asset_number')
            ->addScalarResult('ada_price', 'ada_price')
        ;

        $query = $this->getEntityManager()->createNativeQuery('
            WITH lower_price_by_score AS (
                SELECT
                    b.score,
                    b.asset_number,
                    bs.lovelace_price,
                    RANK() OVER (PARTITION BY b.score ORDER BY bs.lovelace_price ASC) AS score_rank
                FROM bike_sale bs
                INNER JOIN bike b on b.id = bs.bike_id
                WHERE bs.lovelace_price > 0
            )
            
            SELECT score, asset_number, (lovelace_price / 1000000) AS ada_price
            FROM lower_price_by_score
            WHERE score_rank = 1
        ', $rsm);

        return $query->getResult();
    }
}
