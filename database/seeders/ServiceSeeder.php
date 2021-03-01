<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'name' => 'Facebook',
                'url' => 'https://web.facebook.com/'
            ],
            [
                'name' => 'Twitter',
                'url' => 'https://twitter.com/'
            ],
            [
                'name' => 'Google',
                'url' => 'https://www.google.com/accounts?hl=id'
            ],
            [
                'name' => 'Github',
                'url' => 'https://github.com/'
            ],
            [
                'name' => 'Dropbox',
                'url' => 'https://www.dropbox.com/'
            ],
            [
                'name' => 'Dribbble',
                'url' => 'https://dribbble.com/'
            ],
            [
                'name' => 'Instagram',
                'url' => 'https://www.instagram.com/'
            ],
            [
                'name' => 'Linkedin',
                'url' => 'https://id.linkedin.com/'
            ],
            [
                'name' => 'Wordpress',
                'url' => 'https://wordpress.com/id/'
            ],
            [
                'name' => 'Pinterest',
                'url' => 'https://id.pinterest.com/'
            ],
            [
                'name' => 'Reddit',
                'url' => 'https://www.reddit.com/'
            ]
        ];

        DB::table('services')->insert($services);
    }
}
