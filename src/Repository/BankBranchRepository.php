<?php

namespace App\Repository;

use App\Entity\BankBranch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BankBranch>
 *
 * @method BankBranch|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankBranch|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankBranch[]    findAll()
 * @method BankBranch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankBranchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankBranch::class);
    }

//    /**
//     * @return BankBranch[] Returns an array of BankBranch objects
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

//    public function findOneBySomeField($value): ?BankBranch
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
