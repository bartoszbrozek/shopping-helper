<?php

namespace App\Service;

use App\Entity\ShoppingList;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\ShoppingListRepository;

final class ShoppingListService
{
    /**
     * @var ShoppingListRepository
     */
    private $repository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @param ShoppingListRepository $repository
     * @param ProductRepository $productRepository
     */
    public function __construct(ShoppingListRepository $repository, ProductRepository $productRepository)
    {
        $this->repository = $repository;
        $this->productRepository = $productRepository;
    }

    /**
     * Get one shopping list by id
     *
     * @param integer $id
     * @return ShoppingList|null
     */
    public function get(int $id): ?ShoppingList
    {
        return $this->repository->findOneByID($id);
    }

    /**
     * Get all shopping lists
     *
     * @return array|null
     */
    public function getAll(): ?array
    {
        return $this->repository->findAll();
    }

    /**
     * Create Shopping List
     *
     * @param string $name
     * @return ShoppingList
     */
    public function create(string $name): ShoppingList
    {
        $shoppingList = new ShoppingList();
        $shoppingList->setName($name);
        $this->repository->getEM()->persist($shoppingList);
        $this->repository->getEM()->flush();

        return $shoppingList;
    }

    /**
     * Update Shopping List
     *
     * @param integer $id
     * @param string $name
     * @return ShoppingList|null
     */
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

    /**
     * Delete Shopping List
     *
     * @param integer $id
     * @return void
     */
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

    /**
     * Add Product
     *
     * @param integer $shoppingListID
     * @param integer $productID
     * @return ShoppingList|null
     */
    public function addProduct(int $shoppingListID, int $productID): ?ShoppingList
    {
        /**
         * @var ShoppingList
         */
        $shoppingList = $this->repository->findOneByID($shoppingListID);

        /**
         * @var Product
         */
        $product = $this->productRepository->findOneByID($productID);

        if ($product) {
            $shoppingList->addProduct($product);
        }

        return $shoppingList;
    }

    /**
     * Remove Product
     *
     * @param integer $shoppingListID
     * @param integer $productID
     * @return ShoppingList|null
     */
    public function removeProduct(int $shoppingListID, int $productID): ?ShoppingList
    {
        /**
         * @var ShoppingList
         */
        $shoppingList = $this->repository->findOneByID($shoppingListID);

        /**
         * @var Product
         */
        $product = $this->productRepository->findOneByID($productID);

        if ($product) {
            $shoppingList->removeProduct($product);
        }

        return $shoppingList;
    }
}
