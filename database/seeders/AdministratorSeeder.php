<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'name' => 'Test',
            'email' => 'admin@gmail.com',
            'isAdmin' => true
        ], ['password' => bcrypt('123456')]);
    }
}
