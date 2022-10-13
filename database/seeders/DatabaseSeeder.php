<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Fabrício',
            'email' => 'fsgkof@gmail.com',
        ]);

        User::factory()->create([
            'name' => 'Teste',
            'email' => 'teste@gmail.com',
        ]);

        $this->call(CountrySeeder::class);


    }
}
