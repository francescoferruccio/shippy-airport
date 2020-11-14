<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Airport;

class FlightController extends Controller
{
    public function trovaVolo(Request $request) {
        // SE DESTINAZIONE = PARTENZA TORNO INDIETRO E MOSTRO UN MESSAGGIO DI ERRORE
        if($request['departure'] == $request['arrival']) {
            return  back()->withErrors(['error' => 'La destinazione deve essere diversa dalla partenza.']);
        } else {
            // recupero i paramentri della richiesta
            $departure = $request['departure'];
            $arrival = $request['arrival'];
            // recupero da db solo i voli che partono o arrivano agli aeroporti richiesti
            $voli_in_partenza = Flight::where('code_departure', $departure)->get();
            $voli_totali = [];
            $voloEconomico = [];
    
            // dd($voli_in_partenza);
            // ciclo i voli in partenza dall'aeroporto richiesto
            foreach ($voli_in_partenza as $volo) {
                // se il volo arriva all'aeroporto richiesto lo pusho tra i risultati
                if($volo->arrival['code'] == $arrival) {
                    $voli_totali[] = [
                        'code_departure' => $volo['code_departure'],
                        'name_departure' => $volo->departure['name'],
                        'code_arrival' => $volo['code_arrival'],
                        'name_arrival' => $volo->arrival['name'],
                        'price' => $volo['price']
                    ];
                } else {
                    // altrimenti ciclo gli scali
                    $scali = $volo->arrival->flights;
                    foreach ($scali as $scalo) {
                        // se lo scalo parte dall'aeroporto di arrivo del primo volo lo pusho tra i risultati
                        if($scalo['code_arrival'] == $arrival) {
                            $voli_totali[] = [
                                'code_departure' => $volo['code_departure'],
                                'name_departure' => $volo->departure['name'],
                                'code_scalo' => $scalo['code_departure'],
                                'name_scalo' => $scalo->departure['name'],
                                'code_arrival' => $scalo['code_arrival'],
                                'name_arrival' => $scalo->arrival['name'],
                                'price' => $volo['price'] + $scalo['price']
                            ];
                        }
                    }
                }
            }
            // dd($voli_totali);
            // se ho trovato dei risultati li ciclo per trovare quello con il prezzo più basso
            if(count($voli_totali) != 0) {
                foreach ($voli_totali as $volo) {
                    // se non ho ancora un volo valido salvo quello attuale
                    if(count($voloEconomico) == 0) {
                        $voloEconomico = $volo;
                    } else {
                        // altrimenti confronto il prezzo attuale con quello del volo memorizzato e scarto quello con il prezzo più alto
                        if($volo['price'] < $voloEconomico['price']) {
                            $voloEconomico = $volo;
                        }
                    }
                }
            }
        }
        return view('result', compact('voloEconomico'));
    }
}
