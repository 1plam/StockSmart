<?php

namespace App\Presentation\Providers;

use App\Application\Services\DiscountCodeService;
use App\Application\Services\Interfaces\DiscountCodeServiceInterface;
use App\Application\Services\Interfaces\OrderItemServiceInterface;
use App\Application\Services\Interfaces\OrderServiceInterface;
use App\Application\Services\Interfaces\ProductServiceInterface;
use App\Application\Services\Interfaces\UserServiceInterface;
use App\Application\Services\OrderItemService;
use App\Domain\Repositories\DiscountCodeRepositoryInterface;
use App\Domain\Repositories\OrderItemRepositoryInterface;
use App\Infrastructure\Repositories\DiscountCodeRepository;
use App\Infrastructure\Repositories\OrderItemRepository;
use Illuminate\Support\ServiceProvider;
use App\Application\Services\OrderService;
use App\Application\Services\ProductService;
use App\Application\Services\UserService;
use App\Domain\Repositories\OrderRepositoryInterface;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Repositories\OrderRepository;
use App\Infrastructure\Repositories\ProductRepository;
use App\Infrastructure\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(OrderItemServiceInterface::class, OrderItemService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(DiscountCodeServiceInterface::class, DiscountCodeService::class);

        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderItemRepositoryInterface::class, OrderItemRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DiscountCodeRepositoryInterface::class, DiscountCodeRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
