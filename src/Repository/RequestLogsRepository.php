<?php

namespace App\Repository;

use App\Entity\RequestLogs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RequestLogs>
 *
 * @method RequestLogs|null find($id, $lockMode = null, $lockVersion = null)
 * @method RequestLogs|null findOneBy(array $criteria, array $orderBy = null)
 * @method RequestLogs[]    findAll()
 * @method RequestLogs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestLogsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequestLogs::class);
    }

    //    /**
    //     * @return RequestLogs[] Returns an array of RequestLogs objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RequestLogs
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
