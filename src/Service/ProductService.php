<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\ShoppingList;
use App\Repository\ProductRepository;

final class ProductService
{
    private $repository;

    public function __construct(ProductRepository $repository)
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

    public function create(string $name, string $description): Product
    {
        $product = new Product();
        $product
            ->setName($name)
            ->setDescription($description);

        $this->repository->getEM()->persist($product);
        $this->repository->getEM()->flush();

        return $product;
    }

    public function update(int $id, string $name, string $description): ?Product
    {
        /**
         * @var Product
         */
        $product = $this->repository->findOneByID($id);

        if (!$product) {
            return null;
        }

        $product
            ->setName($name)
            ->setDescription($description)
            ->setUpdatedAt(new \DateTime());

        $this->repository->getEM()->persist($product);
        $this->repository->getEM()->flush();

        return $product;
    }

    public function delete(int $id): void
    {
        /**
         * @var Product
         */
        $product = $this->repository->findOneByID($id);

        if ($product) {
            $this->repository->getEM()->remove($product);
        }
    }
}
