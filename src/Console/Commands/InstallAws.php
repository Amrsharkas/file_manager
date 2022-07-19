<?php

namespace Emam\Filemanager\Console\Commands;

use Illuminate\Console\Command;

class InstallAws extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:AWS';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'set config of AWS';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle()
    {
        $this->info('Installing AWS ...');
        $system = $this->option('system');
        if ($system=='windows'){
            exec('msiexec.exe /i https://awscli.amazonaws.com/AWSCLIV2.msi');
        }
        else{
            $key=config('filesystems.disks.s3.key');
            $secret=config('filesystems.disks.s3.secret');
            $region=config('filesystems.disks.s3.region');
            exec('cd ~ && 
            curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip" && 
            apt-get  install unzip && 
            unzip awscliv2.zip && 
             ./aws/install --update &&
             aws configure set aws_access_key_id '.$key.' --profile default && 
             aws configure set aws_secret_access_key '.$secret.' --profile default &&
             aws configure set region '.$region.' --profile default && aws configure set output "json" --profile default');
        }
        $this->info('Installed AWS');
    }
}
