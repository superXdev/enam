<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application.';

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
        $this->call('migrate:fresh');
        $this->call('key:generate');
        $this->call('db:seed', ['--class' => 'UserSeeder']);
        $this->call('db:seed', ['--class' => 'ServiceSeeder']);
        $this->call('db:seed', ['--class' => 'TagSeeder']);
        $this->call('optimize');
        $this->line('Done!');
    }
}
