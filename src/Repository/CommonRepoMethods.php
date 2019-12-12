<?php

namespace App\Repository;

use Doctrine\ORM\Mapping\Entity;

trait CommonRepoMethods
{
    public function findOneByID(int $id): ?Entity
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getEM()
    {
        return $this->getEntityManager();
    }
}
