<?php

namespace App\Repository;

use App\Entity\TrickMultimedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrickMultimedia>
 *
 * @method TrickMultimedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickMultimedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickMultimedia[]    findAll()
 * @method TrickMultimedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickMultimediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrickMultimedia::class);
    }

    public function add(TrickMultimedia $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TrickMultimedia $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TrickMultimedia[] Returns an array of TrickMultimedia objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TrickMultimedia
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
