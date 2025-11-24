<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetProductsInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:product {file=products.json}';

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
        $filename = $this->argument('file');
        $jsonFile = storage_path('app/imports/' . $filename);

        $this->info("Найден файл: {$jsonFile}");
        try {
            $jsonContent = file_get_contents($jsonFile);
            $data = json_decode($jsonContent, true);
            // dd($data);

            $this->info("Найдено товаров: " . count($data));

            $bar = $this->output->createProgressBar(count($data));
            $bar->start();

            $imported = 0;

            foreach ($data as $product) {
                $category = Category::firstOrCreate([
                    'name' => $product['category']
                ]);
                Product::firstOrCreate([
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'brand' => $product['brand'],
                    'size' => $product['size'],
                    'color' => $product['color'],
                    'material' => $product['material'],
                    'gender' => $product['gender'],
                    'price' => $product['price'],
                    'category_id' => $category->id,
                    'discount_percentage' => $product['discountPercentage'],
                    'stock' => $product['stock'],
                    'thumbnail' => $product['thumbnail'],
                    'images' => json_encode($product['images'])
                ]);

                $imported++;
                $bar->advance();
            }

            $bar->finish();
            $this->newLine(2);

            $this->info("✅ Импорт завершен!");
            $this->info("Импортировано: {$imported}");
        } catch (\Exception $e) {
            $this->error("Ошибка: " . $e->getMessage());
            Log::error("Import command error: " . $e->getMessage());
            return 1;
        }
    }
}
