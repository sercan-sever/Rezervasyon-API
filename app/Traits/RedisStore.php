<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

trait RedisStore
{

    public function cachePut(string $key, mixed $value, Carbon $seconds): bool
    {
        return Cache::driver('redis')->put($key, $value, $seconds);
    }

    public function cacheGet(string $key): mixed
    {
        return Cache::driver('redis')->get($key);
    }

    public function cacheForget(string $key): bool
    {
        return Cache::driver('redis')->forget($key);
    }
}
