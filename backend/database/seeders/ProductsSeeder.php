<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Cerveja',
            'description' => 'Uma cerveja gelada',
            'alcoholic' => true,
            'preparable' => false,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Product::create([
            'name' => 'Suco de laranja',
            'description' => 'Um suco natural de laranja',
            'alcoholic' => false,
            'preparable' => true,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Product::create([
            'name' => 'Refrigerante',
            'description' => 'Um refrigerante gelado',
            'alcoholic' => false,
            'preparable' => false,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
