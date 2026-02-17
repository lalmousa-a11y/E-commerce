<?php

namespace App\Services;

use App\Contracts\CacheServiceInterface;
use Illuminate\Support\Facades\Cache;

class RedisCacheService implements CacheServiceInterface
{
    public function remember(string $key, int $ttl, callable $callback)
    {
        return Cache::remember($key, $ttl, $callback);
    }

    public function forget(string $key): bool
    {
        return Cache::forget($key);
    }

    public function flush(): bool
    {
        return Cache::flush();
    }
}
