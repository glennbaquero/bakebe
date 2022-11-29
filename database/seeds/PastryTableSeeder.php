<?php

use Illuminate\Database\Seeder;

use App\Models\Pastries\Pastry;
use App\Models\Pastries\Category;

class PastryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pastry::truncate();
    	
        $row = 0;
        
        if(($handle = fopen('database/csv/pastries.csv', "r")) !== FALSE){
        	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $this->command->info('writing row ' . $row . ' ' . $data[3]);

                $category = Category::firstOrCreate(['name' => $data[0]]);

                $item = new Pastry();
                $item->category_id = $category->id;
                $item->difficulty = $data[1];
                $item->duration = $data[2];
                $item->name = $data[3];
                $item->description = $data[4] != '' ? $data[4] : null;
                $item->image_path = $data[5] != '' ? $data[5] : null;
                $item->express_duration = $data[6];

                $item->save();

                $row++;

            }
            fclose($handle);
        }
    }
}
