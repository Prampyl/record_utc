<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Academic', 'description' => 'Records related to academic achievements'],
            ['name' => 'Sports', 'description' => 'Records related to sports achievements'],
            ['name' => 'Arts', 'description' => 'Records related to artistic achievements'],
            ['name' => 'Community Service', 'description' => 'Records related to community service'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}