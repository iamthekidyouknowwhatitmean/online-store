<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

class GetFakeStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-fake-store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $responses = json_decode(file_get_contents('https://fakestoreapi.com/products'), true);

        foreach ($responses as $response) {
            $attributes = [
                'name' => $response['title'],
                'price' => $response['price'],
                'description' => $response['description'],
                'category' => $response['category']
            ];
            Product::create($attributes);
            Category::create([
                'name' => $response['category']
            ]);
        }
    }
}
