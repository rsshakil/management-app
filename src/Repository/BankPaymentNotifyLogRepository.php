<?php

namespace App\Repository;

use App\Entity\BankPaymentNotifyLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BankPaymentNotifyLog>
 *
 * @method BankPaymentNotifyLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankPaymentNotifyLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankPaymentNotifyLog[]    findAll()
 * @method BankPaymentNotifyLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankPaymentNotifyLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankPaymentNotifyLog::class);
    }

    //    /**
    //     * @return BankPaymentNotifyLog[] Returns an array of BankPaymentNotifyLog objects
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

    //    public function findOneBySomeField($value): ?BankPaymentNotifyLog
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
