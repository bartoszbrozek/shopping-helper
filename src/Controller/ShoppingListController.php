<?php

namespace App\Controller;

use App\Service\ShoppingListService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ShoppingListController extends AbstractFOSRestController
{
    private $shoppingListService;

    public function __construct(ShoppingListService $shoppingListService)
    {
        $this->shoppingListService = $shoppingListService;
    }

    public function getShoppingsAction()
    {
        $data = $this->shoppingListService->getAll();

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * Get Shopping List
     *
     * @param integer $id
     * @return \FOS\RestBundle\View\View
     */
    public function getShoppingAction(int $id)
    {
        $data = $this->shoppingListService->get($id);

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @Rest\RequestParam(name="name", description="Name of shopping list", nullable=false)
     * @param ParamFetcherInterface $paramFetcher
     * @return \FOS\RestBundle\View\View
     */
    public function postShoppingAction(ParamFetcherInterface $paramFetcher)
    {
        $name = $paramFetcher->get('name');

        $shoppingList = $this->shoppingListService->create($name);
        return $this->view($shoppingList, Response::HTTP_CREATED);
    }

    /**
     * @Rest\RequestParam(name="name", description="Name of shopping list", nullable=false)
     * @param int $id
     * @param ParamFetcherInterface $paramFetcher
     * @return \FOS\RestBundle\View\View
     */
    public function patchShoppingAction(int $id, ParamFetcherInterface $paramFetcher)
    {
        $name = $paramFetcher->get('name');
        $shoppingList = $this->shoppingListService->update($id, $name);

        return $this->view($shoppingList, Response::HTTP_CREATED);
    }

    /**
     * Delete shopping list
     *
     * @param integer $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteShoppingAction(int $id)
    {
        $this->shoppingListService->delete($id);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Add product to shopping list
     *
     * @param integer $shoppingID
     * @param integer $productID
     * @return \FOS\RestBundle\View\View
     */
    public function patchShoppingProductAction(int $shoppingID, int $productID)
    {
        $data = $this->shoppingListService->addProduct($shoppingID, $productID);

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * Remove product from shopping list
     *
     * @param integer $shoppingID
     * @param integer $productID
     * @return \FOS\RestBundle\View\View
     */
    public function deleteShoppingProductAction(int $shoppingID, int $productID)
    {
        $data = $this->shoppingListService->removeProduct($shoppingID, $productID);

        return $this->view($data, Response::HTTP_OK);
    }
}
