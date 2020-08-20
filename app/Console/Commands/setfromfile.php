<?php

namespace App\Console\Commands;

use App\Category;
use App\Product;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class setfromfile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filedata:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setdata from file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        DB::beginTransaction();
        try {
            $categoriesFromFile = json_decode(Storage::get('categories.json'), true);
            foreach ($categoriesFromFile as $categoryFromFile) {
                $validator = Validator::make(
                    $categoryFromFile,
                    [
                        'name'      => 'required|max:200',
                        'parent_id' => 'sometimes|integer',
                    ]
                );
                if ($validator->fails()) {
                    return -1;
                }
                $save = new Category(
                    ['name' => $categoryFromFile['name'], 'external_id' => $categoryFromFile['external_id']]
                );
                $save->save();
            }
            $this->line('categories are saved');
            $productsFromFile = json_decode(Storage::get('products.json'), true);
            foreach ($productsFromFile as $productFromFile) {
                $productValidator = Validator::make(
                    $productFromFile,
                    [
                        'name'        => 'required|string|max:200',
                        'description' => 'string|max:1000',
                        'price'       => 'required|numeric',
                        'quantity'    => 'required|integer',
                        'external_id' => 'integer',
                    ]
                );
                if ($productValidator->fails()) {
                    $this->line($productValidator->errors());

                    return -1;
                }
                $product = new Product(
                    [
                        'name'        => $productFromFile['name'],
                        'price'       => $productFromFile['price'],
                        'quantity'    => $productFromFile['quantity'],
                        'external_id' => $productFromFile['external_id'],
                    ]
                );
                $product->save();
                $categories = $productFromFile['category_id'] ?? [];
                $product->categories()->sync($categories);
            }
            DB::commit();
            $this->line('products are saved');
        } catch (Exception $e) {
            DB::rollBack();
            $this->line($e->getMessage());

            return -1;
        }

        return 0;
    }

}
