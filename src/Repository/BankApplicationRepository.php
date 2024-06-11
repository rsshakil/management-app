<?php

namespace App\Repository;

use App\Entity\BankApplication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BankApplication>
 *
 * @method BankApplication|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankApplication|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankApplication[]    findAll()
 * @method BankApplication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankApplication::class);
    }

    //    /**
    //     * @return BankApplication[] Returns an array of BankApplication objects
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

    //    public function findOneBySomeField($value): ?BankApplication
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
