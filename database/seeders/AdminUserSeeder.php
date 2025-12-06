<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@gacoan.com'],
            [
                'name' => 'Gacoan Manager',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@gacoan.com'],
            [
                'name' => 'Staf Kasir',
                'password' => Hash::make('kasir123'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Akun Admin & Kasir berhasil dibuat / diperbarui!');
    }
}
