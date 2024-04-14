<?php

namespace App\Repository;

use App\Entity\Basket;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Basket>
 *
 * @method Basket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Basket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Basket[]    findAll()
 * @method Basket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BasketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Basket::class);
    }
    public function getRandomBaskets(int $limit = 21): array
    {
        $baskets = $this->findAll();
        shuffle($baskets);
        return array_slice($baskets, 0, $limit);
    }
    public function findBySearch(SearchData $searchData)
    {
        $queryBuilder = $this->createQueryBuilder('b');

        if (!empty($searchData->q)) {
            $queryBuilder
                ->leftJoin('b.category', 'cat')
                ->leftJoin('b.tailles', 't')
                ->leftJoin('b.couleurs', 'color')
                ->andWhere('b.nom LIKE :keyword OR b.prix LIKE :keyword OR cat.type LIKE :keyword OR t.taille LIKE :keyword OR color.color LIKE :keyword')
                ->setParameter('keyword', '%' . $searchData->q . '%');
        }
        
        $data = $queryBuilder->getQuery()->getResult();

        return $data;
    }

    //    /**
    //     * @return Basket[] Returns an array of Basket objects
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

    //    public function findOneBySomeField($value): ?Basket
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
