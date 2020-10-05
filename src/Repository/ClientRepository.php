<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }


    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }

    public function hasParent($id) {
        $em = $this->getEntityManager();
        //$qb = $em->createQueryBuilder();

        $works = $em->createQuery(
            'SELECT c.*
            FROM App\Entity\Client c
            HAVING c.parent = :val 
            GROUP BY c.name
            ORDER BY name ASC
            '
        )->setParameter('id', $id);;

        return $works->execute();

    }

    public function recentClients()
    {
        $em = $this->getEntityManager();
        $cli = ("SELECT DISTINCT 
                        c.id,
                        c.name,
                        c.status,
                        w.date_submitted AS 'last_date'
                    FROM WORK w
                    JOIN CLIENT c ON
                        c.id = w.client_id_id
                    WHERE
                        w.date_submitted =(
                        SELECT
                            MAX(w2.date_submitted)
                        FROM WORK w2
                        WHERE
                            w2.client_id_id = w.client_id_id
                    )
                    ORDER BY
                        w.date_submitted
                    DESC");

        $stmt = $em->getConnection()->prepare($cli);
        $stmt->execute();
        return $stmt->fetchAll();

    }






    // /**
    //  * @return Client[] Returns an array of Client objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
