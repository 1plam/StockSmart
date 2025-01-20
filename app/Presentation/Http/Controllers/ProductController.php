<?php

namespace App\Presentation\Http\Controllers;

use App\Application\Services\Interfaces\ProductServiceInterface;
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

    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();
        return ProductResource::collection($products)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function show(string $id): JsonResponse
    {
        $product = $this->productService->getProduct($id);
        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(CreateProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->validated());
        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateProductRequest $request, string $id): JsonResponse
    {
        $product = $this->productService->updateProduct($id, $request->validated());
        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->productService->deleteProduct($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
