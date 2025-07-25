<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CategorieSeeder::class,
            ProduitSeeder::class,
        ]);
    }
}
