<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Airport;
use App\Models\Flight;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // creo 100 voli random
        Flight::factory()->count(100)->make()->each(function($flight){
            // prendo due aeroporti a caso
            $airports = Airport::inRandomOrder()->take(2)->get();
            $departure = $airports->first();
            $arrival = $airports->last();

            // assegno i due aeroporti come partenza e arrivo del volo e salvo il volo nel db
            $flight -> departure() -> associate($departure);
            $flight['code_departure'] = $departure['code'];
            $flight -> arrival() -> associate($arrival);
            $flight['code_arrival'] = $arrival['code'];

            $flight->save();
        });
    }
}
