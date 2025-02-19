<?php

namespace App\Repository;

use App\Entity\Reviews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reviews>
 */
class ReviewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reviews::class);
    }

    public final function findAllWidthPagination(int $page, int $limit): array
    {
        $query = $this->createQueryBuilder('re')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery();

        $paginator = new Paginator($query);
        return [
            'reviews' => $paginator->getQuery()->getResult(),
            'totalItems' => count($paginator),
            'totalPages' => ceil(count($paginator) / $limit)
        ];
    }


    public final function findReviewsPerRoomWithPagination(int $page, int $limit, ?int $roomId = null): array
    {
        $queryBuilder = $this->createQueryBuilder('re');

        // Ajout de la condition pour la room si une room est fournie
        if ($roomId !== null) {
            $queryBuilder
                ->join('re.roomId', 'r')
                ->andWhere('r.id = :roomId')
                ->setParameter('roomId', $roomId);
        }

        $queryBuilder
            ->setFirstResult(($page - 1) * $limit) // Pagination : premier résultat
            ->setMaxResults($limit); // Pagination : nombre de résultats

        $query = $queryBuilder->getQuery();

        $paginator = new Paginator($query);

        return [
            'reviews' => $paginator->getQuery()->getResult(),
            'totalItems' => count($paginator),
            'totalPages' => ceil(count($paginator) / $limit)
        ];
    }

    //    /**
    //     * @return Reviews[] Returns an array of Reviews objects
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

    //    public function findOneBySomeField($value): ?Reviews
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
