<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function getAllCustomersByCompanyId($id): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT id, first_name, last_name, email, phone_number 
            FROM customer
            WHERE company_id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetchAll();
    }
    public function searchCustomers($pattern = '*', $companyId): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            SELECT id, first_name, last_name, email, phone_number 
            FROM customer
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
//     * @return Customer[] Returns an array of Customer objects
//     */
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
    public function findOneBySomeField($value): ?Customer
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
