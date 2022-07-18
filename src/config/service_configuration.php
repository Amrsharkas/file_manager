<?php
return [
    'disk'=>'s3',
    'denyAll'=>false,
    'middlewares'=>[\Emam\Filemanager\Http\Middleware\Fm\setRootPath::class],
    'filePermissions'=>'App\\Services\\FilePermission\\FilePermissionPartner',
    'PermissionsCache'=>true,
    'PermissionsCacheTime'=>true,
    'services' => [
        'App\Services\Storage\FileStructure' => [
            'handler' => 'App\Services\Storage\FileStructure',
            'config' => [
                'separator' => '/',
                'disk'=>'s3',
                'aws_bucket'=>env('AWS_BUCKET')
            ],
        ],

        'App\Services\Cache\CacheServerInterface' => [
            'used'=>true,
            'timeout'=>3600, //in seconds
            'handler' => 'App\Services\Cache\Adapters\CacheSystem',
            'config' => [
                'host' => '127.0.0.1',
                'port' => '6379',
            ],
        ],

        'App\Services\Tmpfs\TmpfsInterface' => [
            'handler' => 'App\Services\Tmpfs\Adapters\Tmpfs',
            'config' => [
                'expired_after' => 24*60*60,// 1 days  this expiration in second
                'path'=>'temp_downloads',
                'path_to_expiration_file'=>'expiration.json'
            ],
        ],
    ],
    'file_permissions'=>'Emam\FileManager\App\Services\FilePermission\FilePermissionPartner',
];
