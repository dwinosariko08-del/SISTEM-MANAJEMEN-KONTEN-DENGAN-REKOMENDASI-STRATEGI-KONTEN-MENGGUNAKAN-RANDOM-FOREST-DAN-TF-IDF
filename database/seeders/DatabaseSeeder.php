<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        $this->call(DatasetMlAugmentedSeeder::class);
    }
}

 /**
*<?php

*namespace Database\Seeders;

*use Illuminate\Database\Console\Seeds\WithoutModelEvents;
*use Illuminate\Database\Seeder;

*class DatabaseSeeder extends Seeder
*{
   * use WithoutModelEvents;

  
   * public function run(): void
*{
   * $this->call(UserSeeder::class);
    

*}

*}
*/