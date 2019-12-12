<?php

namespace App\Controller;

use App\Service\ProductService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ProductController extends AbstractFOSRestController
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProductsAction()
    {
        $data = $this->productService->getAll();

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * Get Shopping List
     *
     * @param integer $id
     * @return \FOS\RestBundle\View\View
     */
    public function getProductAction(int $id)
    {
        $data = $this->productService->get($id);

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @Rest\RequestParam(name="name", description="Name of product", nullable=false)
     * @param ParamFetcherInterface $paramFetcher
     * @return \FOS\RestBundle\View\View
     */
    public function postProductAction(ParamFetcherInterface $paramFetcher)
    {
        $name = $paramFetcher->get('name');
        $description = $paramFetcher->get('description');

        $product = $this->productService->create($name, $description);
        return $this->view($product, Response::HTTP_CREATED);
    }

    /**
     * @Rest\RequestParam(name="name", description="Name of product", nullable=false)
     * @param int $id
     * @param ParamFetcherInterface $paramFetcher
     * @return \FOS\RestBundle\View\View
     */
    public function patchProductAction(int $id, ParamFetcherInterface $paramFetcher)
    {
        $name = $paramFetcher->get('name');
        $description = $paramFetcher->get('description');
        $product = $this->productService->update($id, $name, $description);

        return $this->view($product, Response::HTTP_CREATED);
    }

    /**
     * Delete shopping list
     *
     * @param integer $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteProductAction(int $id)
    {
        $this->productService->delete($id);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
