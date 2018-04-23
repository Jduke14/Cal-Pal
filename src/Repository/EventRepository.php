<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findAllEventsByDate(): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT e.id, e.start_date, e.end_date, e.comments, e.provider_id, e.service_id, c.first_name, c.last_name, e.customer_id, e.company_id, p.first_name as p_first_name, p.last_name as p_last_name, s.type, s.duration 
            FROM event e 
            left join customer c 
            on e.customer_id = c.id 
            left join provider p
            on e.provider_id = p.id
            left join service s
            on e.service_id = s.id
            WHERE e.company_id = 1';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
    }

    public function getEventById($id): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT e.id, e.start_date, e.end_date, e.comments, e.provider_id, e.service_id, c.first_name, c.last_name, e.customer_id, e.company_id 
            FROM event e 
            join customer c 
            on e.customer_id = c.id 
            WHERE e.company_id = 1 
            AND e.id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetch();
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
