<?php

namespace App\Repository;

use App\Entity\Rooms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rooms>
 */
class RoomsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rooms::class);
    }


    public final function findAllWidthPagination(int $page, int $limit): array
    {
        $query = $this->createQueryBuilder('r')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery();

        $paginator = new Paginator($query);
        return [
            'rooms' => $paginator->getQuery()->getResult(),
            'totalItems' => count($paginator),
            'totalPages' => ceil(count($paginator) / $limit)
        ];
    }

    public final function findRoomsPerCategoryWithPagination(int $page, int $limit, ?int $categoryId = null): array
    {
        $queryBuilder = $this->createQueryBuilder('r');

        // Ajout de la condition pour la catégorie si une catégorie est fournie
        if ($categoryId !== null) {
            $queryBuilder
                ->join('r.category', 'c') // Jointure avec l'entité catégorie
                ->andWhere('c.id = :categoryId') // Condition sur l'ID de la catégorie
                ->setParameter('categoryId', $categoryId); // Paramètre pour éviter les injections SQL
        }

        $queryBuilder
            ->setFirstResult(($page - 1) * $limit) // Pagination : premier résultat
            ->setMaxResults($limit); // Pagination : nombre de résultats

        $query = $queryBuilder->getQuery();

        $paginator = new Paginator($query);

        return [
            'rooms' => $paginator->getQuery()->getResult(),
            'totalItems' => count($paginator),
            'totalPages' => ceil(count($paginator) / $limit)
        ];
    }


    //    /**
    //     * @return Rooms[] Returns an array of Rooms objects
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

    //    public function findOneBySomeField($value): ?Rooms
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
