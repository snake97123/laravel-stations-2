<?php

namespace Database\Seeders;

use App\Practice;
use App\Models\Movie;
use App\Models\Sheet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['column' => 1, 'row' => 'a'],
            ['column' => 2, 'row' => 'a'],
            ['column' => 3, 'row' => 'a'],
            ['column' => 4, 'row' => 'a'],
            ['column' => 5, 'row' => 'a'],
            ['column' => 1, 'row' => 'b'],
            ['column' => 2, 'row' => 'b'],
            ['column' => 3, 'row' => 'b'],
            ['column' => 4, 'row' => 'b'],
            ['column' => 5, 'row' => 'b'],
            ['column' => 1, 'row' => 'c'],
            ['column' => 2, 'row' => 'c'],
            ['column' => 3, 'row' => 'c'],
            ['column' => 4, 'row' => 'c'],
            ['column' => 5, 'row' => 'c'],
        ];

        foreach ($data as $sheet) {
            Sheet::create($sheet);
        }
    }
}
