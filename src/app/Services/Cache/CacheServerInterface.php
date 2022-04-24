<?php

namespace Ie\FileManager\App\Services\Cache;

interface CacheServerInterface
{
    public function connectToCacheServer($config) ;

    public function storeToCacheServer($key,$value,$time);

    public function fetchFromCacheServer($key);

    public function forgetFromCacheServer($key);

    public function existInCacheServer($key);
}
