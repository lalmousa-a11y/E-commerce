<?php

namespace App\Contracts;

interface CacheServiceInterface
{
    public function remember(string $key, int $ttl, callable $callback);
    public function forget(string $key): bool;
    public function flush(): bool;
}
