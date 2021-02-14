<?php

namespace App\Console\Commands;

use App\Models\{Service, User, Account};
use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
        $this->info('Inserting services data');
        $this->createService();
        $this->info('Create admin user');
        $this->createAdminUser();
        $this->info('Create account sample');
        $this->createAccountSample();
        $this->line('Done!');
    }

    public function createService()
    {
        $services = [
            [
                'name' => 'Facebook',
                'url' => 'https://web.facebook.com/'
            ],
            [
                'name' => 'Gmail',
                'url' => 'https://gmail.com/'
            ]
        ];

        Service::insert($services);
    }

    public function createAdminUser()
    {
        $user = [
            'name' => 'Admin',
            'email' => 'admin@web.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];

        User::create($user);
    }

    public function createAccountSample()
    {
        $data = [
            'user_id' => 1,
            'service_id' => 1,
            'data' => serialize(['username' => 'guest', 'password' => '123abc']),
            'note' => 'Ini adalah contoh.'
        ];

        Account::create($data);
    }
}