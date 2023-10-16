<?php

namespace App\Repository;

use App\Entity\Curiculum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Curiculum>
 *
 * @method Curiculum|null find($id, $lockMode = null, $lockVersion = null)
 * @method Curiculum|null findOneBy(array $criteria, array $orderBy = null)
 * @method Curiculum[]    findAll()
 * @method Curiculum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuriculumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Curiculum::class);
    }

//    /**
//     * @return Curiculum[] Returns an array of Curiculum objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Curiculum
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
