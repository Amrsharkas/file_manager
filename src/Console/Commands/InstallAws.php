<?php

namespace ie\fm\App\Console\Command;

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
        exec('aws configure set aws_access_key_id '.env('AWS_KEY').' --profile default && aws configure set aws_secret_access_key '.env('AWS_SECRET').' --profile default && aws configure set region '.env('AWS_REGION').' --profile default && aws configure set output "json" --profile default');
        $this->info('Installed AWS');
    }
}
