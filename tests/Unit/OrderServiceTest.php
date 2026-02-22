<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\OrderService;
use App\Contracts\OrderRepositoryInterface;
use App\Contracts\NotificationServiceInterface;
use App\Contracts\CacheServiceInterface;
use App\Models\Order;
use App\Models\User;
use Mockery;

class OrderServiceTest extends TestCase
{
    public function test_complete_order_sends_notification()
    {
        // Mock dependencies
        $orderRepo = Mockery::mock(OrderRepositoryInterface::class);
        $notification = Mockery::mock(NotificationServiceInterface::class);
        $cache = Mockery::mock(CacheServiceInterface::class);

        $cartItem = Mockery::mock('alias:App\\Models\\CartItem');
        $cartItem->shouldReceive('where')->once()->with('user_id', 1)->andReturnSelf();
        $cartItem->shouldReceive('delete')->once()->andReturn(1);

        $user = new User(['email' => 'test@example.com']);
        $user->id = 1;

        $order = new Order(['user_id' => 1]);
        $order->id = 1;
        $order->setRelation('user', $user);

        // Set expectations
        $orderRepo->shouldReceive('update')->once()->with($order, Mockery::type('array'))->andReturn($order);
        $notification->shouldReceive('sendOrderConfirmation')->once()->with($order, $user);
        $cache->shouldReceive('forget')->once()->with('user_orders_1');

        // Inject mocks
        $service = new OrderService($orderRepo, $notification, $cache);
        
        $service->completeOrder($order, 'txn_123');

        $this->assertTrue(true);
    }
}
