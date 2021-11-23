<?php

namespace App\Repository;

use App\Entity\FrontendForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FrontendForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method FrontendForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method FrontendForm[]    findAll()
 * @method FrontendForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FrontendFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FrontendForm::class);
    }

    // /**
    //  * @return FrontendForm[] Returns an array of FrontendForm objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FrontendForm
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
