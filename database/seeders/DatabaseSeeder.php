<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Buat User Siswa (untuk testing)
        User::create([
            'name' => 'Faraz Seskoal',
            'email' => 'faraz@seskoal.id',
            'password' => Hash::make('faraz123'),
            'role' => 'siswa',
        ]);

        $this->command->info('Seeders berhasil! Akun Admin & Siswa sudah siap.');
    }
}
