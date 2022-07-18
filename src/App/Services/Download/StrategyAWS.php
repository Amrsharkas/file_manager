<?php

namespace Emam\Filemanager\App\Services\Download;

use Aws\Sdk;
use function PHPUnit\Framework\fileExists;

class StrategyAWS extends  CommonBrodcast
{
    private $full_size;
    private $s3Client;
    private $config;


    public function download($current,$paths,$archiver,$fileSystem){
        $path_server=public_path('temp_downloads'.DIRECTORY_SEPARATOR.$current);
        if ($this->folder_exist($path_server)==false){
            mkdir($path_server,0777,true);
            chmod($path_server,0777);
        }
        $this->config=config('service_configuration');
        $filePermissions=app()->make($this->config['filePermissions']);;
        $disk=$this->setSetting();
        $availablity=$filePermissions->getAvailablity();
        $setting=config('filesystems.disks.'.$disk);
        $sharedConfig = [
            'profile' => 'default',
            'region' => $setting['region'],
            'version' => 'latest',
        ];
        $this->s3Client = (new Sdk($sharedConfig))->createS3();
        if ($availablity){
            $allowed_permissions=$filePermissions->getPermissions(false);
            $allowed_permissions_collection=collect($allowed_permissions);
            $allowed_permissions_array=$allowed_permissions_collection->pluck('path')->toArray();
            foreach ($paths as $path){
                if (in_array($path['path'],$allowed_permissions_array) && $path['type']=='file'){
                  //  $this->downlodFile($path['path'],$path_server.DIRECTORY_SEPARATOR.$path['name']);
                   exec('aws s3 cp s3://'.env('AWS_BUCKET').'/'.$path['path'].' '.$path_server.' --profile default');
                }
                else if (in_array($path['path'],$allowed_permissions_array) && $path['type']=='dir'){
                    $first_parent=$path_server.DIRECTORY_SEPARATOR.$path['name'];
                    if ($this->folder_exist($first_parent)==false) {
                        mkdir($first_parent, 0777,true);
                        chmod($first_parent,0777);
                    }
                    $this->creatDirectoriesRecursive($allowed_permissions_collection,$allowed_permissions_array,$path,$path_server,$fileSystem,$first_parent);
                }
            }
        }
        else{
            foreach ($paths as $path){
                if ($path['type']=='dir'){
                    $overwrite_path=$path_server.DIRECTORY_SEPARATOR.$path['name'];
                    if ($this->folder_exist($overwrite_path)==false){
                        mkdir($overwrite_path,0777,true);
                        chmod($overwrite_path,0777);
                    }
                //    $this->downlodDirectory($path['path'],$overwrite_path);
                     exec('aws s3 cp s3://'.env('AWS_BUCKET').'/'.$path['path'].' '.$overwrite_path.' --recursive'.' --profile default');
                }
                elseif ($path['type']=='file'){
                  //  $this->downlodFile($path['path'],$path_server.DIRECTORY_SEPARATOR.$path['name']);
                      exec('aws s3 cp s3://'.env('AWS_BUCKET').'/'.$path['path'].' '.$path_server.' --profile default');
                }

            }
        }
        $this->full_size=$this->folderSize($path_server);
        $this->compress($path_server);
    }

    private function downlodDirectory($sourcePath,$destinationPath){
        //$dest .= '/'.$path['name'];
        $source = 's3://'.env('AWS_BUCKET').'/'.$sourcePath;
        $manager = new \Aws\S3\Transfer($this->s3Client, $source, $destinationPath);
        $manager->transfer();
    }

    private function downlodFile($source,$destination){
        $this->s3Client->getObject(array(
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $source,
            'SaveAs' => $destination
        ));
    }


    public function creatDirectoriesRecursive($allowed_permissions_collection,$allowed_permissions_array,$path_data,$path_server,$fileSystem,$first_parent)
    {
        $inners = $allowed_permissions_collection->where('parent', $path_data['path']);
        foreach ($inners as $inner) {
            if (in_array($inner->path,$allowed_permissions_array) && $inner->type == 'dir') {
                $overwrite_path = $first_parent . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $fileSystem->getBaseName($inner->path));
                if ($this->folder_exist($overwrite_path)==false) {
                    try {
                        mkdir($overwrite_path, 0777,true);
                        chmod($overwrite_path,0777);
                    } catch (\Exception $e) {
                        dump('error');
                    }
                }
                $this->creatDirectoriesRecursive($allowed_permissions_collection,$allowed_permissions_array,
                    [
                        'type' => 'dir',
                        'path' => $inner->path,
                        'name' => $fileSystem->getBaseName($inner->path)
                    ], $path_server, $fileSystem, $overwrite_path);
            } else if (in_array($inner->path,$allowed_permissions_array) && $inner->type == 'file') {
                $overwrite_path = $first_parent . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $fileSystem->getBaseName($inner->path));
                if (!file_exists($overwrite_path)){
                   // $this->downlodFile($inner->path,$overwrite_path);
                     exec('aws s3 cp s3://'.env('AWS_BUCKET').'/'.$inner->path.' '.$overwrite_path.' --profile default');
                }
            }
        }
    }

    public function compress($path_server){
        $rootPath = realpath($path_server);
        $zip = new \ZipArchive();
        $zip->open($rootPath.'.zip', \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        /** @var SplFileInfo[] $files */
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($rootPath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        $result=0;
        foreach ($files as $name => $file)
        {
            if (is_file($file))
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                $file_size=filesize($filePath);
                $percentage = $file_size/$this->full_size * 100;
                $result +=(int) $percentage;
                $this->brodcastMessage(($result+1)/100);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
    }

    function folder_exist($folder)
    {
        $path = realpath($folder);
        if($path !== false AND is_dir($path))
        {
            return $path;
        }
        return false;
    }

    private function setSetting(){
        $credential=$this->config['services']['App\Services\Storage\FileStructure'];
        $disk=$credential['config']['disk'];
        return $disk;
    }
}
