<?php

namespace Database\Seeders;

use App\Models\KeyWord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $keyWord = new KeyWord; 
          $keyWord->keywords = 'phone,nokia';
          $keyWord->save();
        
    }
}
