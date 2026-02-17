<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\OrderService;
use App\Contracts\OrderRepositoryInterface;
use App\Contracts\NotificationServiceInterface;
use App\Contracts\CacheServiceInterface;
use Mockery;

class OrderServiceTest extends TestCase
{
    public function test_complete_order_sends_notification()
    {
        // Mock dependencies
        $orderRepo = Mockery::mock(OrderRepositoryInterface::class);
        $notification = Mockery::mock(NotificationServiceInterface::class);
        $cache = Mockery::mock(CacheServiceInterface::class);

        $order = (object) ['id' => 1, 'user_id' => 1, 'user' => (object)['email' => 'test@example.com']];

        // Set expectations
        $orderRepo->shouldReceive('update')->once()->andReturn($order);
        $notification->shouldReceive('sendOrderConfirmation')->once();
        $cache->shouldReceive('forget')->once();

        // Inject mocks
        $service = new OrderService($orderRepo, $notification, $cache);
        
        $service->completeOrder($order, 'txn_123');

        $this->assertTrue(true);
    }
}
