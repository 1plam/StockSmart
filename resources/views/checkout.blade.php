@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            {{-- Header Section --}}
            <header class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-900">Checkout</h1>
                <p class="mt-2 text-sm text-gray-600">Order #{{ substr($order->getId(), 0, 8) }}</p>
            </header>

            <div class="grid gap-6">
                {{-- Order Items Section --}}
                <section class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="p-6">
                        <ul class="divide-y divide-gray-200">
                            @foreach($order->getItems() as $item)
                                <li class="py-4 flex items-center">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">
                                            Order Item #{{ $item->getId() }}
                                            <br>
                                            {{ $products[$item->getProductId()]->getName() }}
                                        </h3>
                                        <div class="mt-1 flex items-center text-sm text-gray-500">
                                            <span>Quantity: {{ $item->getQuantity() }}</span>
                                            <span class="mx-2">•</span>
                                            <span>€{{ number_format($item->getUnitPrice(), 2) }} each</span>
                                        </div>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">
                                        Total price: €{{ number_format($item->getTotalPrice(), 2) }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>

                {{-- Discount Section --}}
                <section class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Discount Code</h2>
                        <form action="{{ route('checkout.apply-discount', $order->getId()) }}" method="POST">
                            @csrf
                            <div class="flex space-x-4">
                                <div class="flex-1">
                                    <input
                                            type="text"
                                            name="discount_code"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            placeholder="Enter your discount code"
                                            value="{{ old('discount_code', $order->getDiscountCode()) }}"
                                    >
                                    @error('discount_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button
                                        type="submit"
                                        class="px-4 py-2 bg-gray-900 text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-sm font-medium"
                                >
                                    Apply
                                </button>
                            </div>
                        </form>
                    </div>
                </section>

                {{-- Order Summary Section --}}
                <section class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="p-6">
                        <dl class="space-y-3">
                            <div class="flex justify-between text-sm text-gray-600">
                                <dt>Subtotal</dt>
                                <dd>€{{ number_format($order->getTotalAmount() + $order->getDiscountAmount(), 2) }}</dd>
                            </div>

                            @if($order->getDiscountAmount() > 0)
                                <div class="flex justify-between text-sm text-green-600">
                                    <dt>Discount ({{ $order->getDiscountCode() }})</dt>
                                    <dd>-€{{ number_format($order->getDiscountAmount(), 2) }}</dd>
                                </div>
                            @endif

                            <div class="pt-3 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <dt class="text-base font-medium text-gray-900">Total</dt>
                                    <dd class="text-xl font-semibold text-gray-900">
                                        €{{ number_format($order->getTotalAmount(), 2) }}
                                    </dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                </section>
                {{-- Payment Button Section --}}
                <section class="mt-2">
                    <form action="{{ route('checkout.process', $order->getId()) }}" method="POST">
                        @csrf
                        <button
                                type="submit"
                                class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-base font-medium transition-colors"
                        >
                            Proceed to Payment
                        </button>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection
