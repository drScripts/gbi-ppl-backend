<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            'name' => 'Festival Citylink',
            'unique_code' => 'FC',
            'maps_link' => 'https://www.google.com/maps/dir/-6.9815467,107.5623846/gbi+ppl+festival+citylink/@-6.9586572,107.5641597,14z/data=!4m9!4m8!1m1!4e1!1m5!1m1!1s0x2e68e8a7e2821e3d:0x478fedefc6a11902!2m2!1d107.5860291!2d-6.9298829'
        ]);

        DB::table('regions')->insert([
            'name' => 'Kopo',
            'unique_code' => 'KP',
            'maps_link' => 'https://www.google.com/maps/place/GBI+PPL+KOPO/@-6.9638844,107.5776982,15z/data=!4m2!3m1!1s0x0:0xd6598a3a97d06f37?sa=X&ved=2ahUKEwjG-OG_suP1AhVR8HMBHWEjAdsQ_BJ6BAgdEAU'
        ]);

        DB::table('regions')->insert([
            'name' => 'Majesty',
            'unique_code' => 'MJ',
            'maps_link' => 'https://www.google.com/maps/place/GBI+PPL+Majesty/@-6.8832861,107.5810472,15z/data=!4m2!3m1!1s0x0:0x5b25e0156ea6a8a5?sa=X&ved=2ahUKEwiYhJbZsuP1AhVj7nMBHZbYAUkQ_BJ6BAgfEAU'
        ]);
    }
}
