<?php

namespace App\Service;

use App\Entity\ShoppingList;
use App\Repository\ShoppingListRepository;

final class ShoppingListService
{
    private $repository;

    public function __construct(ShoppingListRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(int $id): ?ShoppingList
    {
        return $this->repository->findOneByID($id);
    }

    public function getAll(): ?array
    {
        return $this->repository->findAll();
    }

    public function create(string $name): ShoppingList
    {
        $shoppingList = new ShoppingList();
        $shoppingList->setName($name);
        $this->repository->getEM()->persist($shoppingList);
        $this->repository->getEM()->flush();

        return $shoppingList;
    }

    public function update(int $id, string $name): ?ShoppingList
    {
        /**
         * @var ShoppingList
         */
        $shoppingList = $this->repository->findOneByID($id);

        if (!$shoppingList) {
            return null;
        }

        $shoppingList
            ->setName($name)
            ->setUpdatedAt(new \DateTime());

        $this->repository->getEM()->persist($shoppingList);
        $this->repository->getEM()->flush();

        return $shoppingList;
    }

    public function delete(int $id): void
    {
        /**
         * @var ShoppingList
         */
        $shoppingList = $this->repository->findOneByID($id);

        if ($shoppingList) {
            $this->repository->getEM()->remove($shoppingList);
        }
    }
}
