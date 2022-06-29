<?php

namespace ie\fm\App\Console\Command;


use ie\fm\App\Services\Storage\FileStructure;
use ie\fm\App\Services\Tmpfs\Adapters\Tmpfs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RemoveExpirationFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:expiredFiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired files than exceed time that user determine in package configuration';
    /**
     * @var string
     */
    private $path;
    /**
     * @var mixed
     */
    private $expired_at;
    /**
     * @var FileStructure
     */
    private $tmpfs;
    /**
     * @var mixed
     */
    private $baseDir;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Tmpfs $tmpfs)
    {
        parent::__construct();
        $this->tmpfs=$tmpfs;
        $service_configuration = config('service_configuration.services');
        $credential=$service_configuration['App\Services\Tmpfs\TmpfsInterface'];
        $this->baseDir=$credential['config']['path'];
        $this->path=$this->baseDir.'/'.$credential['config']['path_to_expiration_file'];
        $this->expired_at=$credential['config']['expired_after'];
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle()
    {
        $inp = file_get_contents(public_path().'/'.$this->path);
        $tempArray = json_decode($inp,1);
        $tempArrayCollection=collect($tempArray);
        $expiration_files=$tempArrayCollection
            ->where('expire_at','<',date('Y-m-d H:i:s',
                strtotime('-'.$this->expired_at.' second')))
            ->pluck('uuid')
            ->toArray();

        foreach ($expiration_files as $expiration_file){
            try{
                $this->tmpfs->remove($expiration_file,public_path().'/');
            }
            catch (\Exception $exception){
                throw new \Exception($exception->getMessage());
            }
        }
        $validDownloads=   $tempArrayCollection->reject(function($element) use ($expiration_files) {
            return in_array($element['uuid'],$expiration_files);
        });
        $jsonData = json_encode($validDownloads->toArray());
        file_put_contents(public_path().'/'.$this->path, $jsonData);
    }
}
