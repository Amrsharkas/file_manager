<?php

namespace Ie\FileManager\Console;

use Illuminate\Console\Command;

class InstallFm extends Command
{
    protected $signature = 'FileManager:install';

    protected $description = 'Install the FileManager';

    public function handle()
    {
        $this->info('Installing FileManager ...');

        $this->info('Publishing FileManager...');

        $this->call('vendor:publish', [
            '--provider' => "Ie\FileManager\FileUploaderServiceProvider",
            '--tag' => "config"
        ]);

        $this->info('Installed FileManager');
    }
}