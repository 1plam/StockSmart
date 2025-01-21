<?php

namespace App\Presentation\Http\Controllers;

use App\Application\Services\Interfaces\OrderServiceInterface;
use App\Application\Services\Interfaces\DiscountCodeServiceInterface;
use App\Application\Services\Interfaces\ProductServiceInterface;
use App\Domain\Exceptions\DiscountCodeNotFoundException;
use App\Domain\Exceptions\OrderNotFoundException;
use App\Presentation\Http\Requests\DiscountCodes\ApplyDiscountCodeRequest;
use DomainException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

final class CheckoutController extends Controller
{
    public function __construct(
        private readonly OrderServiceInterface        $orderService,
        private readonly ProductServiceInterface      $productService,
        private readonly DiscountCodeServiceInterface $discountCodeService
    )
    {
    }

    /**
     * Display checkout page for the order
     */
    public function show(string $orderId): Factory|\Illuminate\Foundation\Application|View|RedirectResponse|Application
    {
        try {
            $order = $this->orderService->getOrder($orderId);
            $products = [];

            foreach ($order->getItems() as $item) {
                $products[$item->getProductId()] = $this->productService->getProduct($item->getProductId());
            }

            return view('checkout', [
                'order' => $order,
                'products' => $products
            ]);
        } catch (OrderNotFoundException) {
            return redirect()
                ->route('orders.index')
                ->withErrors(['error' => 'Order not found.']);
        }
    }

    /**
     * Apply discount code to the order
     */
    public function applyDiscount(ApplyDiscountCodeRequest $request, string $orderId)
    {
        try {
            $order = $this->orderService->getOrder($orderId);
            $discountCode = $request->input('discount_code');

            $this->discountCodeService->applyDiscountToOrder($discountCode, $order);

            return redirect()->back()->with('success', 'Discount code applied successfully.');
        } catch (DiscountCodeNotFoundException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['discount_code' => 'Invalid discount code.']);
        } catch (DomainException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['discount_code' => $e->getMessage()]);
        }
    }

    /**
     * Process the checkout
     */
    public function process(string $orderId): JsonResponse
    {
        $order = $this->orderService->getOrder($orderId);

        // Here we would typically:
        // 1. Validate the order status
        // 2. Initialize payment processing
        // 3. Redirect to payment gateway or handle payment directly

        // For now, we'll just log it
        Log::info('Processing checkout for order: ' . $orderId);

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Order processed successfully'
            ],
            Response::HTTP_OK
        );
    }
}
