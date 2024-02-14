<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(1)->create();

        $user = \App\Models\User::create([
            'nama' => 'rizky',
            'alamat' => 'cipoho',
            'telp' => '0895331299363',
            'sim' => 'C',
            'email' => 'test@example.com',
            'password' => bcrypt('test123'),
        ]);
        $user2 = \App\Models\User::create([
            'nama' => 'Julian',
            'alamat' => 'cipoho',
            'telp' => '0895331299363',
            'sim' => 'C',
            'email' => 'tes@example.com',
            'password' => bcrypt('test123'),
        ]);
        \App\Models\Mobil::factory(10)->create(['user_id'=>$user->id]);
        \App\Models\Mobil::factory(10)->create(['user_id'=>$user2->id]);
    }
}
