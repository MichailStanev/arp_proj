<?php

namespace App\Repository;

use App\Entity\Vehicles;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Vehicles>
 *
 * @method Vehicles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicles[]    findAll()
 * @method Vehicles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiclesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicles::class);
    }

    public function save(Vehicles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vehicles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getFilterQuery(FormInterface $form, Request $request)
    {
        $queryBuilder = $this->createQueryBuilder('entity');
        $fields = $this->getClassMetadata()->getFieldNames();

        if( null !== $form->get('vehicleName')->getData()){
            $queryBuilder
                ->andWhere('entity.vehicleName LIKE :vehicleName')
                ->setParameter('vehicleName', '%' . $form->get('vehicleName')->getData() . '%');
        }

        if( null !== $form->get('plateNumber')->getData()){
            $queryBuilder
                ->andWhere('entity.plateNumber LIKE :plateNumber')
                ->setParameter('plateNumber', '%' . $form->get('plateNumber')->getData() . '%');
        }

        if( null !== $form->get('category')->getData()){
            $queryBuilder
                ->andWhere('entity.category LIKE :category')
                ->setParameter('category', '%car%');
        }

        if( null !== $form->get('acquiringDate')->getData()){
            $queryBuilder
                ->andWhere('entity.acquiringDate LIKE :acquiringDate')
                ->setParameter('acquiringDate', '%' . $form->get('acquiringDate')->getData() . '%');
        }

        if( null !== $form->get('fuelType')->getData()){
            $queryBuilder
                ->andWhere('entity.fuelType LIKE :fuelType')
                ->setParameter('fuelType', '%' . $form->get('fuelType')->getData() . '%');
        }

        $queryBuilder->orderBy('entity.id', Criteria::ASC);

        return $queryBuilder->getQuery();
    }

//    /**
//     * @return Vehicles[] Returns an array of Vehicles objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vehicles
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
