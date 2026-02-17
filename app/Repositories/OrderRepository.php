<?php

namespace App\Repositories;

use App\Contracts\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function all(): Collection
    {
        return Order::with(['items.product', 'user'])->get();
    }

    public function find(int $id): ?Order
    {
        return Order::with(['items.product', 'user'])->find($id);
    }

    public function findByUser(int $userId): Collection
    {
        return Order::where('user_id', $userId)
            ->with(['items.product'])
            ->latest()
            ->get();
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function update(Order $order, array $data): Order
    {
        $order->update($data);
        return $order->fresh(['items.product', 'user']);
    }

    public function delete(Order $order): bool
    {
        return $order->delete();
    }
}
