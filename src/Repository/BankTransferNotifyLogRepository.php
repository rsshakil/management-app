<?php

namespace App\Repository;

use App\Entity\BankTransferNotifyLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BankTransferNotifyLog>
 *
 * @method BankTransferNotifyLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankTransferNotifyLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankTransferNotifyLog[]    findAll()
 * @method BankTransferNotifyLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankTransferNotifyLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankTransferNotifyLog::class);
    }

    //    /**
    //     * @return BankTransferNotifyLog[] Returns an array of BankTransferNotifyLog objects
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

    //    public function findOneBySomeField($value): ?BankTransferNotifyLog
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
