<?php
return [
    'disk'=>'s3',
    'denyAll'=>false,
    'middlewares'=>[\Emam\Filemanager\Http\Middleware\fm\setRootPath::class],
    'filePermissions'=>'App\\Services\\FilePermission\\FilePermissionPartner',
    'PermissionsCache'=>true,
    'PermissionsCacheTime'=>true,
    'services' => [
        'App\Services\Storage\FileStructure' => [
            'handler' => 'App\Services\Storage\FileStructure',
            'config' => [
                'separator' => '/',
                'disk'=>'s3',
                'adapter' => function () {
//    return  new \League\Flysystem\Adapter\Local('uploads');
//                   return new \League\Flysystem\Adapter\Ftp([
//                        'host' => '206.189.55.61',
//                        'username' => 'projectUser',
//                        'password' => '123456789',
//                        'port' => 21,
//                    ]);
                    $client = new \Aws\S3\S3Client([
                        'credentials' => [
                            'key' => env('AWS_KEY'),
                            'secret' => env('AWS_SECRET'),
                            'region' => env('AWS_REGION'),
                        ],
                        'region' => env('AWS_REGION'),
                        'version' => 'latest',
                    ]);
                    return new \League\Flysystem\AwsS3v3\AwsS3Adapter($client, env('AWS_BUCKET'));
                },
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
    'file_permissions'=>'Ie\FileManager\App\Services\FilePermission\FilePermissionPartner',
];
