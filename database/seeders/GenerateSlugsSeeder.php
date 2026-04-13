<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Facility;
use App\Models\Product;

class GenerateSlugsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update Facilities without slugs
        $facilities = Facility::whereNull('slug')->orWhere('slug', '')->get();
        foreach ($facilities as $facility) {
            $facility->slug = Str::slug($facility->name);
            $facility->save();
            $this->command->info("Updated facility: {$facility->name} -> {$facility->slug}");
        }

        // Update Products without slugs
        $products = Product::whereNull('slug')->orWhere('slug', '')->get();
        foreach ($products as $product) {
            $product->slug = Str::slug($product->name);
            $product->save();
            $this->command->info("Updated product: {$product->name} -> {$product->slug}");
        }

        $this->command->info("Facilities updated: {$facilities->count()}");
        $this->command->info("Products updated: {$products->count()}");
    }
}
