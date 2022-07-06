<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateExpirationFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:expirationFile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create expiration file for downloads';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Creating file');
        fopen(public_path('temp_downloads/expiration.json'), 'w');
        $this->info('Created file');
    }
}
