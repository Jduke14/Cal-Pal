<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function getAllServicesByCompanyId($id): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT id, type, duration 
            FROM service
            WHERE company_id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetchAll();
    }

    public function searchServices($pattern = '*', $companyId): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT id, type, duration 
            FROM service
            WHERE company_id = ? 
            and type like ?';
            $stmt = $conn->prepare($sql);
            $pattern = $pattern.'%';
            $stmt->bindParam(1, $companyId);
            $stmt->bindParam(2, $pattern);
            $stmt->execute();
            return $stmt->fetchAll();
    }
//    /**
//     * @return Service[] Returns an array of Service objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Service
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
