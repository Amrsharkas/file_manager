<?php

namespace Ie\FileManager\App\Services\Download;

class StrategyAWS extends  CommonBrodcast
{
    private $full_size;
    
    
    public function download($current,$paths,$archiver,$fileSystem){
        $path_server=public_path('temp_downloads\\'.$current);
        if (!is_dir($path_server)){
            mkdir($path_server,777);
        }
        foreach ($paths as $path){
          //  dd('aws s3 cp s3://'.env('AWS_BUCKET').'/'.$path['path'].' '.$path_server.' --recursive');
            if ($path['type']=='dir'){
                $overwrite_path=$path_server.'\\'.$path['name'];
                if (!is_dir($path_server)){
                    mkdir($overwrite_path,777);
                }
                exec('aws s3 cp s3://'.env('AWS_BUCKET').'/'.$path['path'].' '.$overwrite_path.' --recursive');
            }
            elseif ($path['type']=='file'){
                exec('aws s3 cp s3://'.env('AWS_BUCKET').'/'.$path['path'].' '.$path_server);
            }

        }
        $this->full_size=$this->folderSize($path_server);
        $this->compress($path_server);
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
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                $file_size=filesize($filePath);
                $percentage = $file_size/$this->full_size * 100;
                $result +=(int) $percentage;
                $this->brodcastMessage(($result)/100);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
    }


}
