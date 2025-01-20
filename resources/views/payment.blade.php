@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <div class="text-center">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
                    <h1 class="text-2xl font-semibold text-gray-900 mb-4">Processing Payment</h1>
                    <p class="text-gray-600 mb-4">Order #{{ substr($orderId, 0, 8) }}</p>

                    <div id="status-message" class="mt-4">
                        <div class="animate-pulse flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing your order...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
          // Simple script to handle the payment status response
          document.addEventListener('DOMContentLoaded', function () {
            // This would connect to your process() controller method
            // and handle the JSON response
            const statusMessage = document.getElementById('status-message');

            // Simulate the response from your controller
            setTimeout(() => {
              statusMessage.innerHTML = `
            <div class="text-green-600 flex items-center justify-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Order processed successfully
            </div>
        `;
            }, 2000);
          });
        </script>
    @endpush
@endsection
