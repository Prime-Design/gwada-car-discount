<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Récupérer des valeurs distinctes pour un champ donné
     */
    public function findDistinctValues(string $field): array
    {
        return $this->createQueryBuilder('p')
            ->select("DISTINCT p.$field")
            ->orderBy("p.$field", 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Rechercher les annonces en fonction des filtres avec pagination
     */
    public function findFilteredPaginatedPosts(array $filters, int $page, int $limit = 6): Paginator
    {
        $qb = $this->createQueryBuilder('p');

        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                switch ($key) {
                    case 'marque':
                        $qb->andWhere('p.marque = :marque')
                            ->setParameter('marque', $value);
                        break;
                    case 'modele':
                        $qb->andWhere('p.modele = :modele')
                            ->setParameter('modele', $value);
                        break;
                    case 'energie':
                        $qb->andWhere('p.energie = :energie')
                            ->setParameter('energie', $value);
                        break;
                    case 'prix_min':
                        $qb->andWhere('p.prix >= :prix_min')
                            ->setParameter('prix_min', (float)$value);
                        break;
                    case 'prix_max':
                        $qb->andWhere('p.prix <= :prix_max')
                            ->setParameter('prix_max', (float)$value);
                        break;
                    case 'kilometres_min':
                        $qb->andWhere('p.kilometres >= :kilometres_min')
                            ->setParameter('kilometres_min', (int)$value);
                        break;
                    case 'kilometres_max':
                        $qb->andWhere('p.kilometres <= :kilometres_max')
                            ->setParameter('kilometres_max', (int)$value);
                        break;
                    case 'puissance':
                        $qb->andWhere('p.puissance = :puissance')
                            ->setParameter('puissance', (int)$value);
                        break;
                }
            }
        }

        // Ajout de la pagination
        $qb->orderBy('p.id', 'DESC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return new Paginator($qb);
    }

    /**
     * Récupérer les 8 dernières annonces
     */
    public function findLastEight(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }
}
