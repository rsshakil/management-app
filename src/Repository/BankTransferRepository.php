<?php

namespace App\Repository;

use App\Entity\BankTransfer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BankTransfer>
 *
 * @method BankTransfer|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankTransfer|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankTransfer[]    findAll()
 * @method BankTransfer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankTransferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankTransfer::class);
    }

    //    /**
    //     * @return BankTransfer[] Returns an array of BankTransfer objects
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

    //    public function findOneBySomeField($value): ?BankTransfer
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
