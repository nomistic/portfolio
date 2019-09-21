<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\Work;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Work|null find($id, $lockMode = null, $lockVersion = null)
 * @method Work|null findOneBy(array $criteria, array $orderBy = null)
 * method Work[]    findAll()
 * @method Work[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Work::class);
    }

    public function findAll()
    {
        return $this->findBy(array(), array('title' => 'ASC'));
    }

    public function totalByClient() {
        $em = $this->getEntityManager();
        //$qb = $em->createQueryBuilder();

        $works = $em->createQuery(
            'select c.name, sum(w.net_pay) AS amount, count(w.id) as jobs, sum(w.net_pay)/count(w.id) as average_pay
            FROM App\Entity\Work w
            LEFT JOIN w.client_id c
            GROUP BY c.name
            ORDER BY amount DESC, jobs DESC
            '
        );

        return $works->execute();

    }

    public function TopTotalByClient() {
        $em = $this->getEntityManager();
        //$qb = $em->createQueryBuilder();

        $works = $em->createQuery(
            'select c.name, sum(w.net_pay) AS amount, count(w.id) as jobs, sum(w.net_pay)/count(w.id) as average_pay
            FROM App\Entity\Work w
            LEFT JOIN w.client_id c
            GROUP BY c.name
            ORDER BY amount DESC, jobs DESC
            '
        )->setMaxResults(6);

        return $works->execute();

    }
    public function MostJobsByClient() {
        $em = $this->getEntityManager();
        //$qb = $em->createQueryBuilder();

        $works = $em->createQuery(
            'select c.name, sum(w.net_pay) AS amount, count(w.id) as jobs, sum(w.net_pay)/count(w.id) as average_pay
            FROM App\Entity\Work w
            LEFT JOIN w.client_id c
            GROUP BY c.name
            ORDER BY jobs DESC
            '
        )->setMaxResults(6);

        return $works->execute();

    }

    public function authoredWorks()
    {
        $em = $this->getEntityManager();
        $pubs =  $em->createQuery('select w.title, w.pub_url, w.description, t.name as type
        FROM App\Entity\Work w 
        JOIN w.type t
        WHERE w.ghost_ind = false
        ORDER BY  w.title ASC');

        return $pubs->execute();

    }


    // /**
    //  * @return Work[] Returns an array of Work objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Work
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
