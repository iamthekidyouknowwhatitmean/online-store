<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\News;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $responses = json_decode(file_get_contents('https://fakestoreapi.com/products'), true);

        foreach ($responses as $response) {
            Category::firstOrCreate([
                'name' => $response['category']
            ]);
            $attributes = [
                'name' => $response['title'],
                'price' => $response['price'],
                'description' => $response['description'],
                'category_id' => Category::where('name', $response['category'])->first()->id
            ];
            Product::create($attributes);
        }
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        News::factory()->count(20)->create();
    }
}
