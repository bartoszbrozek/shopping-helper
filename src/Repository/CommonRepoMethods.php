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

    public function findAllByUserID(int $id)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.user = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult();
    }

    public function getEM()
    {
        return $this->getEntityManager();
    }
}
