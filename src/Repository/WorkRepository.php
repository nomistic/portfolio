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

    public function workSubmitted($type)
    {
        $em = $this->getEntityManager();

        if (isset($type)) {
            if ($type == 'All') {
                $condition = "1=1";
            }
            else {
                $condition = "t.name = ?1";
            }

        }
        else {
            $condition = "1=1";
        }

        $works = $em->createQuery(
            "select w
            FROM App\Entity\Work w
            JOIN w.type t
            WHERE w.date_submitted IS NOT NULL
            AND $condition

            ORDER BY w.title asc
            "
        );
        if (isset($type)  && $type != 'All') {
            $works->setParameter(1, $type);
        }

        return $works->execute();
    }

    public function workInProgress()
    {
        $em = $this->getEntityManager();

        $works = $em->createQuery(
            'select w
            FROM App\Entity\Work w
            WHERE w.date_submitted IS NULL
            ORDER BY w.title asc
            '
        );

        return $works->execute();
    }

    public function totalByClient() {
        $em = $this->getEntityManager();

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
    public function totalCounts() {
        $em = $this->getEntityManager();

        $works = $em->createQuery(
            'select w.work_type,  count(w.id) AS number
            FROM App\Entity\Work w
            GROUP BY w.work_type
            ORDER BY number DESC
            '
        );

        return $works->execute();

    }

    public function TopTotalByClient() {
        $em = $this->getEntityManager();

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


    public function submittedWork($id) {
        $em = $this->getEntityManager();

        $works = $em->createQuery(
            'select w
            FROM App\Entity\Work w
            WHERE w.date_submitted IS NOT NULL
            AND w.client_id = ?1
            ')->setParameter(1, $id);


        return $works->execute();
    }

    public function inProgressWork($id) {
        $em = $this->getEntityManager();

        $works = $em->createQuery(
            'select w
            FROM App\Entity\Work w
            WHERE w.date_submitted IS NULL
            AND w.client_id = ?1
            ')->setParameter(1, $id);


        return $works->execute();
    }

    public function clientTotal($id) {
        $em = $this->getEntityManager();

        $works = $em->createQuery(
            'select sum(w.net_pay)
            FROM App\Entity\Work w
            WHERE w.client_id = ?1
            ')->setParameter(1, $id);
        $works->getSingleScalarResult();

        return $works->execute();
    }

    public function childTotal($id) {
        $em = $this->getEntityManager();

        $works = $em->createQuery(
            'select sum(w.net_pay)
            FROM App\Entity\Work w
            LEFT JOIN w.client_id c 
            WHERE c.parent = ?1
            ')->setParameter(1, $id);
        $works->getSingleScalarResult();

        return $works->execute();

    }





    public function MostJobsByClient() {
        $em = $this->getEntityManager();

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
// using raw SQL for monthname and year functions

    public function monthlyEarnings()
    {
        $em = $this->getEntityManager();
        $ern = ("SELECT
                        YEAR(date_submitted) AS year_sub,
                        CONCAT(
                            YEAR(date_submitted),
                            ' ',
                            MONTHNAME(date_submitted)
                        ) AS month_year,
                        SUM(net_pay) AS pay
                    FROM work 
                    WHERE net_pay is not NULL 
                    GROUP BY
                        year_sub,
                        month_year
                    ORDER BY
                        year_sub,
                        MONTH(date_submitted)");

        $stmt = $em->getConnection()->prepare($ern);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function annualEarnings()
    {
        $em = $this->getEntityManager();
        $ern = ("SELECT
                    YEAR(date_submitted) AS year_sub,
                    SUM(net_pay) AS pay
                FROM WORK
                WHERE
                    net_pay IS NOT NULL
                GROUP BY
                    year_sub
                ORDER BY
                    year_sub");

        $stmt = $em->getConnection()->prepare($ern);
        $stmt->execute();
        return $stmt->fetchAll();

    }

    public function clientMonthlyEarnings($id)
    {
        $em = $this->getEntityManager();
        $ern = ("SELECT
                        YEAR(date_submitted) AS year_sub,
                        CONCAT(
                            YEAR(date_submitted),
                            ' ',
                            MONTHNAME(date_submitted)
                        ) AS month_year,
                        SUM(net_pay) AS pay
                    FROM work 
                    WHERE net_pay is not NULL AND client_id_id = :id
                    GROUP BY
                        year_sub,
                        month_year
                    ORDER BY
                        year_sub,
                        MONTH(date_submitted)");

        $stmt = $em->getConnection()->prepare($ern);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();

    }

    public function childMonthlyEarnings($id)
    {
        $em = $this->getEntityManager();
        $ern = ("SELECT
                    YEAR(date_submitted) AS year_sub,
                    CONCAT(
                        YEAR(date_submitted),
                        ' ',
                        MONTHNAME(date_submitted)
                    ) AS month_year,
                    SUM(net_pay) AS pay
                FROM WORK
                WHERE
                    net_pay IS NOT NULL AND client_id_id IN(
                    SELECT
                        id
                    FROM CLIENT
                WHERE
                    parent_id = :id
                )
                GROUP BY
                    year_sub,
                    month_year
                ORDER BY
                    year_sub,
                    MONTH(date_submitted)");

        $stmt = $em->getConnection()->prepare($ern);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();

    }



}
