<?php

use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recipes')->insert([
            [
            'title' => 'Breakfast',
            'subject' => 'Omlet',
            'category' => 'Breakfast',
            'recipe' => 'two eggs smashed together, roughly',
            'tips' => 'Make it hard',
            'image' => 'macaroni.jpg',
            'author_id' => 1
            ],
            [
            'title' => 'Lunch',
            'subject' => 'Steak',
            'category' => 'Lunch',
            'recipe' => 'two steaks baked together',
            'tips' => 'Messy, huh?',
            'image' => 'macaroni.jpg',
            'author_id' => 1
            ],
            [
            'title' => 'Dinner',
            'subject' => 'Soup',
            'category' => 'Dinner',
            'recipe' => 'get something from AH and just put it in the pot.',
            'tips' => 'Make it hard',
            'image' => 'macaroni.jpg',
            'author_id' => 1
            ]
        ]);
    }
}
