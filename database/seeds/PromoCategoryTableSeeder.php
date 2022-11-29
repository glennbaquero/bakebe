<?php

use Illuminate\Database\Seeder;

use App\Models\Promos\PromoCategory;

class PromoCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PromoCategory::truncate();
        $row = 0;
        
        if(($handle = fopen('database/csv/promo_categories.csv', "r")) !== FALSE){
        	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $this->command->info('writing row ' . $row . ' ' . $data[0]);

                $item = new PromoCategory();
                $item->name = $data[0];
                $item->type = $data[1];

                $item->save();

                $row++;

            }
            fclose($handle);
        }
    }
}
