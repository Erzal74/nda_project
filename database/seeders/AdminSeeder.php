<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['nip' => '00000001'], // unik berdasarkan NIP
            [
                'no' => 'ADM-0001', // pastikan unique
                'name' => 'Admin Utama',
                'email' => 'admin@gmail.com',
                'nip' => '00000001', // NIP 8 digit
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'approved',
            ]
        );
    }
}
