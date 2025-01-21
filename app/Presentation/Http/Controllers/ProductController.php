<?php

namespace App\Presentation\Http\Controllers;

use App\Application\Services\Interfaces\ProductServiceInterface;
use App\Domain\Exceptions\ProductNotFoundException;
use App\Presentation\Http\Requests\Products\CreateProductRequest;
use App\Presentation\Http\Requests\Products\UpdateProductRequest;
use App\Presentation\Http\Resources\ProductResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProductController extends Controller
{
    public function __construct(
        private readonly ProductServiceInterface $productService
    )
    {
    }

    /**
     * Get all products.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        return response()->json(ProductResource::collection($products), Response::HTTP_OK);
    }

    /**
     * Get a specific product by ID.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $product = $this->productService->getProduct($id);
        return response()->json(new ProductResource($product), Response::HTTP_OK);
    }

    /**
     * Create a new product.
     *
     * @param CreateProductRequest $request
     * @return JsonResponse
     */
    public function store(CreateProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->validated());
        return response()->json(new ProductResource($product), Response::HTTP_CREATED);
    }

    /**
     * Update an existing product.
     *
     * @param UpdateProductRequest $request
     * @param string $id
     * @return JsonResponse
     * @throws ProductNotFoundException
     */
    public function update(UpdateProductRequest $request, string $id): JsonResponse
    {
        $product = $this->productService->updateProduct($id, $request->validated());
        return response()->json(new ProductResource($product), Response::HTTP_OK);
    }

    /**
     * Delete a product.
     *
     * @param string $id
     * @return JsonResponse
     * @throws ProductNotFoundException
     */
    public function destroy(string $id): JsonResponse
    {
        $this->productService->deleteProduct($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
