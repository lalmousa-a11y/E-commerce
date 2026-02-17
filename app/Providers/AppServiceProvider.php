<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\PaymentGatewayInterface;
use App\Services\PaymentGateways\StripeGateway;
use App\Services\PaymentGateways\PayPalGateway;
use App\Contracts\Product\ProductCrudInterface;
use App\Contracts\Product\ProductSearchInterface;
use App\Contracts\Product\ProductApprovalInterface;
use App\Contracts\Product\ProductImportExportInterface;
use App\Services\Product\ProductCrudService;
use App\Services\Product\ProductSearchService;
use App\Services\Product\ProductApprovalService;
use App\Services\Product\ProductImportExportService;
use App\Contracts\OrderRepositoryInterface;
use App\Contracts\NotificationServiceInterface;
use App\Contracts\CacheServiceInterface;
use App\Repositories\OrderRepository;
use App\Services\EmailNotificationService;
use App\Services\RedisCacheService;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\ProductRepository;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    
        // Bind payment gateway based on config
        $this->app->bind(PaymentGatewayInterface::class, function ($app) {
            $gateway = config('payment.gateway', 'stripe');
            
            return match($gateway) {
                'stripe' => new StripeGateway(),
                'paypal' => new PayPalGateway(),
                default => new StripeGateway(),
            };
        });
        
        // Bind product services
        $this->app->bind(ProductCrudInterface::class, ProductCrudService::class);
        $this->app->bind(ProductSearchInterface::class, ProductSearchService::class);
        $this->app->bind(ProductApprovalInterface::class, ProductApprovalService::class);
        $this->app->bind(ProductImportExportInterface::class, ProductImportExportService::class);

        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(NotificationServiceInterface::class, EmailNotificationService::class);
        $this->app->bind(CacheServiceInterface::class, RedisCacheService::class);
         // Bind Repository Interface to Implementation
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
