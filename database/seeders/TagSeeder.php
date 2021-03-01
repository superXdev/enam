<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Socmed', 'slug' => 'socmed'],
            ['name' => 'Development', 'slug' => 'development'],
            ['name' => 'Blog', 'slug' => 'blog'],
            ['name' => 'Email', 'slug' => 'email'],
            ['name' => 'Office', 'slug' => 'office'],
            ['name' => 'Chat', 'slug' => 'chat'],
            ['name' => 'Wordpress', 'slug' => 'wordpress'],
        ];

        DB::table('tags')->insert($data);
    }
}
