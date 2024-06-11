<?php

namespace App\Repository;

use App\Entity\BankPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BankPayment>
 *
 * @method BankPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankPayment[]    findAll()
 * @method BankPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankPayment::class);
    }

    //    /**
    //     * @return BankPayment[] Returns an array of BankPayment objects
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

    //    public function findOneBySomeField($value): ?BankPayment
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
