<?php

namespace Ie\FileManager\App\Services\FilePermission;

use Ie\FileManager\App\Services\Cache\Adapters\CacheSystem;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Collection;

class FilePermissionPartner implements IFilePermissionPartner
{
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $config;
    /**
     * @var CacheSystem
     */
    private $cache;
    /**
     * @var mixed
     */
    private $cacheUsed;
    /**
     * @var CacheSystem
     */
    private $cacheTimeout;

    public function __construct(CacheSystem $cache)
    {
        $this->config = config('service_configuration');
        $this->cacheUsed=$this->config['PermissionsCache'];
        if ($this->cacheUsed){
            $this->cache=$cache;
            $this->cacheTimeout= $this->config['PermissionsCacheTime'];
        }
    }

    public function getUserID() : ?int
    {
        return Auth::id();
    }


    public function getUsedDisk() : ?string
    {
        return config('service_configuration.disk');
    }


    public function getPermissions($path)
    {
        $config = config('service_configuration');
        $user=$this->getUserID();
        $disk=$this->getUsedDisk();
         if ($config['denyAll'] == true) {
             // you can return array that want
             $dataMapper = new FilePermissionPartnerMapper();
             if (!$this->cacheUsed){
                 return  $dataMapper->fetchPermissions([
                     'user_id'=>$user,
                     'disk'=>$disk,
                     'parent'=>$path
                 ]);
             }
             else{
                 //$this->cache->flushAllInCacheServer();
                 $key=$user.'_'.$disk.'_'.$path.'_'.'permissions';
                 if ($this->cache->existInCacheServer($key)){
                     return  $this->cache->fetchFromCacheServer($key);
                 }
                 else{
                     $permissions=  $dataMapper->fetchPermissions([
                         'user_id'=>$user,
                         'disk'=>$disk,
                         'parent'=>$path
                     ]);
                     $this->cache->storeToCacheServer($key,$permissions,$this->cacheTimeout);
                     return $permissions;
                 }

             }
        }
        return null;
    }
}

