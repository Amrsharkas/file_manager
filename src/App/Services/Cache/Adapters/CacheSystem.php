<?php

namespace Emam\Filemanager\App\Services\Cache\Adapters;


use Emam\Filemanager\App\Services\Cache\CacheServerInterface;
use Emam\Filemanager\App\Services\Storage\FileStructure;
use Illuminate\Support\Facades\Cache;

class CacheSystem implements CacheServerInterface{

    // protected $redis;
    private $fileStructure;


    public function __construct(FileStructure $fileStructure)
    {
        $this->fileStructure=$fileStructure;
    }


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

    public function forgetFromCacheServer($key,$deep=false)
    {
        if (!$deep) {
            Cache::forget($key);
        }
        else{
            $paths= $this->fetchFromCacheServer($key);
            if ($paths){
                $deleted_paths_cache=[];
                $paths=json_decode($paths,1);
                foreach ($paths as $data){
                    if ($data['type']=='dir'){
                        $deleted_paths_cache[]=$this->fileStructure->getSeparator().$data['path'].'_'.$this->fileStructure->getDisk();
                        $this->recursiveGetTreeCache($this->fileStructure->getSeparator().$data['path'].'_'.$this->fileStructure->getDisk(),$deleted_paths_cache);
                    }
                }
                foreach ($deleted_paths_cache as $cache_to_delete){
                    Cache::forget($cache_to_delete);
                }
            }
        }
        //  $this->redis->del($key)
    }

    private function recursiveGetTreeCache($key,&$deleted_paths_cache){
        $paths=$this->fetchFromCacheServer($key);
        if ($paths) {
            $paths = json_decode($paths, 1);
            if (count($paths) > 0) {
                foreach ($paths as $data) {
                    if ($data['type'] == 'dir') {
                        $deleted_paths_cache[] = $this->fileStructure->getSeparator() . $data['path'] . '_' . $this->fileStructure->getDisk();
                        $this->recursiveGetTreeCache($this->fileStructure->getSeparator() . $data['path'] . '_' . $this->fileStructure->getDisk(), $deleted_paths_cache);
                    }
                }
            }
        }
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
