<?php

namespace App\Repository;

use App\Entity\Provider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Provider|null find($id, $lockMode = null, $lockVersion = null)
 * @method Provider|null findOneBy(array $criteria, array $orderBy = null)
 * @method Provider[]    findAll()
 * @method Provider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProviderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Provider::class);
    }

    public function getAllProvidersByCompanyId($id): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT id, first_name, last_name 
            FROM provider
            WHERE company_id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetchAll();
    }

    public function searchProviders($pattern = '*', $companyId): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT id, first_name, last_name 
            FROM provider
            WHERE company_id = ? 
            and first_name like ?';
            $stmt = $conn->prepare($sql);
            $pattern = $pattern.'%';
            $stmt->bindParam(1, $companyId);
            $stmt->bindParam(2, $pattern);
            $stmt->execute();
            return $stmt->fetchAll();
    }

//    /**
//     * @return Provider[] Returns an array of Provider objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Provider
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
