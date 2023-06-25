<?php

namespace App\Repository;

use App\Entity\Goat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Goat>
 *
 * @method Goat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Goat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Goat[]    findAll()
 * @method Goat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Goat::class);
    }

    public function save(Goat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Goat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findByGoatLive(): array
    {     return  $this->createQueryBuilder('g')
            ->andWhere('g.abatido is NULL ')
            ->andWhere('g.deleted_at is NULL')
            ->getQuery()
            ->getResult()
       ;
    }

    public function findForKill(): array
    {     return  $this->createQueryBuilder('g')
            ->andWhere('g.abatido is NULL ')
            ->andWhere('g.deleted_at is NULL')
            ->getQuery()
            ->getResult()
       ;
    }

    public function findByGoatDead(): array
    {     return  $this->createQueryBuilder('g')
            ->andWhere('g.abatido is NOT NULL ')
            ->getQuery()
            ->getResult()
       ;
    }

    public function findLeiteSemanal(): float
    {     return  $this->createQueryBuilder('g')
            ->select('sum(g.leite_prod)')
            ->where('g.abatido is NULL')
            ->andWhere('g.deleted_at is NULL')
            ->getQuery()
            ->getSingleScalarResult()
       ;
    }

    public function findRacaoSemanal(): float
    {     return  $this->createQueryBuilder('g')
            ->select('sum(g.racao_cons)')
            ->where('g.abatido is NULL')
            ->andWhere('g.deleted_at is NULL')
            ->getQuery()
            ->getSingleScalarResult()
       ;
    }

    public function findForGoatKill(): array
    {     return  $this->createQueryBuilder('g')
            ->Where('g.abatido is NULL')
            ->andWhere('g.leite_prod < 40')
            ->andWhere('g.leite_prod < 70 AND g.racao_cons > 350')
            ->andWhere('g.peso > 270')
            ->andWhere('g.pese > 270')
            ->andWhere('g.deleted_at is NULL')
            ->getQuery()
            ->getResult()
       ;
    }


//    /**
//     * @return Goat[] Returns an array of Goat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Goat
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
