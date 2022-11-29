<?php

use Illuminate\Database\Seeder;

use App\Models\Promos\Promo;

class PromoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Promo::truncate();

        $row = 0;
        
        if(($handle = fopen('database/csv/promos.csv', "r")) !== FALSE){
        	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $this->command->info('writing row ' . $row . ' ' . $data[1]);

                $item = new Promo();
                $item->promo_category_id = $data[0];
                $item->name = $data[1];
                $item->description = $data[2];
                $item->discount = $data[3];
                $item->is_percentage = $data[4];
                $item->is_active = $data[5];
                $item->image_path = $data[6];

                $item->save();

                $row++;

            }
            fclose($handle);
        }
    }
}
