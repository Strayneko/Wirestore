<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Image::query()->create([
            'name' => 'no-image.png',
            'size' => 0,
            'extension' => 'PNG',
            'full_path' => 'assets/images/products/no-image.png',
        ]);
    }
}
