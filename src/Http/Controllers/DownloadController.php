<?php

namespace Ie\Src\Http\Controllers;

use App\Services\Archiver\Adapters\CustomZipArchive;
use App\Services\Archiver\Adapters\ZipArchiver;
use App\Services\Archiver\ArchiverInterface;
use App\Services\Download\StrategyAWS;
use App\Services\Download\StrategyDefault;
use App\Services\Download\StrategyDownloadContext;
use App\Services\Download\StrategyLocal;
use App\Services\Storage\FileStructure;
use App\Services\Tmpfs\Adapters\Tmpfs;
use App\Services\Tmpfs\TmpfsInterface;
use Aws\Sdk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    private $archiver;
    /**
     * @var FileStructure
     */
    private $fileSystem;
    private $storage;
    private $strategyDownloadContext;
    /**
     * @var Tmpfs
     */
  //  private $tmpfs;

    public function __construct(FileStructure $fileSystem,
                                StrategyDownloadContext $strategyDownloadContext,
                                ZipArchiver $archiver)
    {
       $this->archiver=$archiver;
       $this->fileSystem=$fileSystem;
       $this->strategyDownloadContext=$strategyDownloadContext;
//       $this->tmpfs=$tmpfs;
    }

    /**
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function downloadSingle(Request $request)
    {
        $data=$request->all();
        if ($data['type']=='file'){
            return  $this->fileSystem->getUrlLink($data['path']);
        }
        else if ($data['type']=='dir'|| $data['type']=='many'){
            $paths=$data['paths'];
            if ($this->fileSystem->getAdapterInstance() instanceof AwsS3Adapter) {
                $this->strategyDownloadContext->setStrategy(new StrategyAWS());
                $this->strategyDownloadContext->createUUid();
                $this->strategyDownloadContext->download($paths,$this->archiver,$this->fileSystem);
                $current= $this->strategyDownloadContext->getUUid();
                $this->strategyDownloadContext->setExpirationForFile($current,public_path().'/');
                return 'temp_downloads/'.$current.'.zip';
            }
            else{
                $this->strategyDownloadContext->setStrategy(new StrategyDefault());
                $this->strategyDownloadContext->download($paths,$this->archiver,$this->fileSystem);
                $current= $this->strategyDownloadContext->getUUid();
                $this->strategyDownloadContext->setExpirationForFile($current.'zip',public_path().'/');
                return 'temp_downloads/'.$current;
            }
//            return $this->downloadAsCompressed($paths);

          //  shell_exec('chmod 777 -R  '.public_path('temp_downloads'));
//            $paths=$data['paths'];
//            $uniqid = $this->archiver->createArchive($this->fileSystem);
//            foreach ($paths as $item) {
//                $item=(object)$item;
//                if ($item->type == 'dir') {
//                    $this->archiver->addDirectoryFromStorage($item->path);
//                }
//                if ($item->type == 'file') {
//                  $this->archiver->addFileFromStorage($item->path);
//                }
//            }
//            $this->archiver->closeArchive();
        }
    }


    public function getDownloadCompressedLink(Request $request, StreamedResponse $streamedResponse)
    {
        $uniqid = (string) $request->input('uniqid');
        $tmpfs=$this->tmpfs;
        $file = $tmpfs->readStream($uniqid);
        $streamedResponse->setCallback(function () use ($file, $tmpfs, $uniqid) {
            set_time_limit(0);
            if ($file['stream']) {
                while (! feof($file['stream'])) {
                    echo fread($file['stream'], 1024 * 8);
                    ob_flush();
                    flush();
                }
                fclose($file['stream']);
            }
        });

        $streamedResponse->headers->set(
            'Content-Disposition',
            HeaderUtils::makeDisposition(
                HeaderUtils::DISPOSITION_ATTACHMENT,'archive.zip')
        );
        $streamedResponse->headers->set(
            'Content-Type',
            'application/octet-stream'
        );
        $streamedResponse->headers->set(
            'Content-Transfer-Encoding',
            'binary'
        );
        if (isset($file['filesize'])) {
            $streamedResponse->headers->set(
                'Content-Length',
                $file['filesize']
            );
        }
        $streamedResponse->send();
    }

    private function downloadAsCompressed($s3Client,$paths)
    {

//        $current=  uniqid();
//        $final_file = public_path('temp_downloads/').$current;
//        exec('mkdir '.$final_file);
//        foreach ($paths as $path){
//            $dest = public_path('temp_downloads/').$current;
//            if ($path['type']=='dir'){
//                $dest .= '/'.$path['name'];
//                $source = 's3://sprint-erp-test/'.$path['path'];
//                $manager = new \Aws\S3\Transfer($s3Client, $source, $dest);
//                $manager->transfer();
//            }
//            elseif($path['type']=='file'){
//                $s3Client->getObject(array(
//                    'Bucket' => 'sprint-erp-test',
//                    'Key' => $path['path'],
//                    'SaveAs' => $dest.'/'.$path['name']
//                ));
//            }
//        }
     //   $this->archiver->addDirectoryFromStorage('temp_downloads/'.$current,1);

//        $zip_file  = 'temp_downloads/'.$current.'.zip';
//        $zip = new \ZipArchive();
//        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
//        $path = 'temp_downloads/'.$current;
//        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
//        $fullSize=$this->folderSize($path);
//        $downloaded=0;
//        foreach ($files as $file)
//        {
//            $filePath = $file->getRealPath();
//            $relativePath =substr($filePath, strlen('public/temp_downloads'.$path.'/'.$current));
//            if (!$file->isDir()) {
//                $zip->addFile($filePath,$relativePath);
//                $downloaded+=$file->getSize();
//                dump($downloaded);
//                event(new \App\Events\SendMessage((int)(($downloaded/$fullSize) * 100)));
//            }
//        }
//        event(new \App\Events\SendMessage(100));

//        $zip = new ZipArchive;
//        $fileName = 'temp_downloads/'.$current.'.zip';
//        if ($zip->open(public_path($fileName), ZipArchive::C) === true)
//        {
//            $files = File::directories(public_path('temp_downloads/'.$current),true);;
//            foreach ($files as $key => $value) {
//                $zip->addEmptyDir($value);
//                $relativeNameInZipFile = basename($value);
//                //dump($value,dirname($value),$relativeNameInZipFile);
//                //$zip->addFile($value, $relativeNameInZipFile);
//            }
//            $zip->close();
//        }

//            foreach ($paths as $item) {
//                $item=(object)$item;
//                if ($item->type == 'dir') {
//                    $this->archiver->addDirectoryFromStorage($item->path);
//                }
//                if ($item->type == 'file') {
//                  $this->archiver->addFileFromStorage($item->path);
//                }
//            }

//        $zip_command=' zip  -r   '.$final_file.'.zip  '.$final_file;
//        $command_to_remove_dir='rm -rf  '.$final_file;
//        exec($zip_command.' && '.$command_to_remove_dir);
     return  'temp_downloads/'.$current.'.zip';
    }

    function folderSize($dir){
        $total_size = 0;
        $count = 0;
        $dir_array = scandir($dir);
        foreach($dir_array as $key=>$filename){
            if($filename!=".." && $filename!="."){
                if(is_dir($dir."/".$filename)){
                    $new_foldersize = $this->foldersize($dir."/".$filename);
                    $total_size = $total_size+ $new_foldersize;
                }else if(is_file($dir."/".$filename)){
                    $total_size = $total_size + filesize($dir."/".$filename);
                    $count++;
                }
            }
        }
        return $total_size;
    }


}
