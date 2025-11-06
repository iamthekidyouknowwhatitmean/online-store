<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetProductsInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-products-info';

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
        $responseProducts = Http::get('https://dummyjson.com/products?limit=75&select=title,description,price,category,discountPercentage')->collect()->all()['products'];
        foreach ($responseProducts as $product) {
            $category = Category::firstOrCreate([
                'name' => $product['category']
            ]);

            $productData = [
                'title' => $product['title'],
                'description' => $product['description'],
                'price' => $product['price'],
                'category_id' => $category->id,
                'discount_percentage' => $product['discountPercentage']
            ];

            Product::firstOrCreate($productData);
        }
    }
}
