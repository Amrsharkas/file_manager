<?php

namespace Emam\Filemanager\App\Services\Cache\Adapters;


use Emam\Filemanager\App\Services\Cache\CacheServerInterface;
use Illuminate\Support\Facades\Cache;

class CacheSystem implements CacheServerInterface{

    protected $redis;


    public function connectToCacheServer($config)
    {

    }


    public function storeToCacheServer($key, $value, $minutes)
    {
        if (!is_null($minutes)){
            Cache::put($key, $value, $minutes);
        }
        else{
            Cache::forever($key,$value);
        }
      //  $this->redis->set($key,$value,$time_in_seconds);
    }

    public function fetchFromCacheServer($key)
    {
        return Cache::get($key);
       // return $this->redis->get($key);
    }

        public function forgetFromCacheServer($key)
    {
        Cache::forget($key);
      //  $this->redis->del($key);
    }

    public function existInCacheServer($key): bool
    {
        return Cache::has($key);
    }

    public function flushAllInCacheServer()
    {
        Cache::flush();
//        return $this->redis->flushAll();
    }

    public function rebuildDataInCacheServer($key,$value,$minutes)
    {
        $this->forgetFromCacheServer($key);
        $this->storeToCacheServer($key,$value,$minutes);
    }
}
