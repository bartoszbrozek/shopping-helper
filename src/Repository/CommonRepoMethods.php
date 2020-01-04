<?php

namespace App\Repository;

trait CommonRepoMethods
{
    public function findOneByID(int $id)
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
