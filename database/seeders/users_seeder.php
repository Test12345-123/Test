<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class users_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Risgan',
                'email' => 'risgan@gmail.com',
                'password' => bcrypt('user123'),
                'id_level' => '1'
            ]
        ];

        foreach ($users as $key => $value) {
            User::create($value);
        }
    }
}
