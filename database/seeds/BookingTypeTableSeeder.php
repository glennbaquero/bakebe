<?php

use Illuminate\Database\Seeder;

use App\Models\Types\BookingType;

class BookingTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BookingType::truncate();
    	
        $row = 0;
        
        if(($handle = fopen('database/csv/booking_types.csv', "r")) !== FALSE){
        	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $this->command->info('writing row ' . $row . ' ' . $data[0]);

                $item = new BookingType();
                $item->name = $data[0];
                $item->description = $data[1];
                $item->image_path = $data[2];
                $item->expected_duration = $data[3];
                $item->rate = $data[4];
                $item->additional_fee = $data[5];

                $item->save();

                $row++;

            }
            fclose($handle);
        }
    }
}
