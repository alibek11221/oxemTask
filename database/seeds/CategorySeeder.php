<?php

use App\Category;
use App\Product;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        factory(Category::class, 50)->create()->each(
            static function ($category) {
                $products = factory(Product::class, 50)->create();
                $category->products()->attach($products);
            }
        );
    }
}
