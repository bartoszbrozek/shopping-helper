<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\ShoppingList;
use App\Repository\ProductRepository;

final class ProductService extends AbstractEntityService
{

    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get one product by ID
     *
     * @param integer $id
     * @return ShoppingList|null
     */
    public function get(int $id): ?ShoppingList
    {
        return $this->repository->findOneByID($id);
    }

    /**
     * Get all products
     *
     * @return array|null
     */
    public function getAll(): ?array
    {
        return $this->repository->findAll();
    }

    /**
     * Create product
     *
     * @param string $name
     * @param string $description
     * @return Product
     */
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

    /**
     * Update product
     *
     * @param integer $id
     * @param string $name
     * @param string $description
     * @return Product|null
     */
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

    /**
     * Delete product
     *
     * @param integer $id
     * @return void
     */
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
