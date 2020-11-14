<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Airport;

class FlightController extends Controller
{
    // FUNZIONE CHE TROVA IL VOLO PIU ECONOMICO TRA QUELLI FORNITI IN INPUT
    public function voloEconomico($flights) {
        $cheapest_flight = [];
        // se i voli forniti contengono un solo volo prendo il primo e unico elemento dell'array e lo restituisco
        if(count($flights) == 1) {
            $cheapest_flight = $flights[0];
        } else {
            $first = true;
            
            // altrimenti ciclo i voli forniti e seleziono quello con il prezzo più basso
            foreach ($flights as $flight) {
                if($first) {
                    $cheapest_flight = $flight;
                    $first = false;
                } else {
                    // in caso di voli con stesso prezzo scarta quelli successivi, quindi avremo sempre un volo diretto se presente
                    if($flight['price'] < $cheapest_flight['price']) {
                        $cheapest_flight = $flight;
                    }
                }
            }

        }
        // restituisco il volo più economico
        return $cheapest_flight;
    }

    public function trovaVolo(Request $request) {
        // dd($request);
        
        // SE DESTINAZIONE = PARTENZA TORNO INDIETRO E MOSTRO UN MESSAGGIO DI ERRORE
        if($request['departure'] == $request['arrival']) {
            return  back()
            ->withErrors(['error' => 'La destinazione deve essere diversa dalla partenza.']);
        } else {
            // mi ricavo tutti i voli da db
            $flights = Flight::all();
            // prendo i dati che mi servono dalla richiesta
            $departure = $request['departure'];
            $arrival = $request['arrival'];
            // creo l'array per memorizzare i voli che corrispondono alla ricerca
            $voli_trovati = [];
    
            // ciclo i voli per trovare quelli che partono dall'aeroporto di partenza dato in input
            foreach ($flights as $flight) {
                if($flight['code_departure'] == $departure) {
                    // se i voli trovati arrivano all'aeroporto di destinazione dato in input li inserisco nei risultati
                    if($flight['code_arrival'] == $arrival) {
                        $voli_trovati[] = [
                            'code_departure' => $flight['code_departure'],
                            'name_departure' => $flight->departure['name'],
                            'code_arrival' => $flight['code_arrival'],
                            'name_arrival' => $flight->arrival['name'],
                            'price' => $flight['price']
                        ];
                    } else {
                        // se i voli trovati arrivano in un aeroporto diverso controllo se esistono voli
                        // che partono da quell'aeroporto e arrivano all'aeroporto di destinazione dato in input
                        foreach ($flights as $scalo) {
                            if($scalo['code_departure'] == $flight['code_arrival'] && $scalo['code_arrival'] == $arrival) {
                                // se esiste inserisco nei risultati le informazione riguardo
                                // partenza, scalo, destinazione e la somma dei prezzi dei due voli
                                $voli_trovati[] = [
                                    'code_departure' => $flight['code_departure'],
                                    'name_departure' => $flight->departure['name'],
                                    'code_scalo' => $scalo['code_departure'],
                                    'name_scalo' => $scalo->departure['name'],
                                    'code_arrival' => $scalo['code_arrival'],
                                    'name_arrival' => $scalo->arrival['name'],
                                    'price' => $flight['price'] + $scalo['price']
                                ];
                            }
                        }
                    }
                }
            }
            // l'array conterrà prima i voli diretti, se presenti, e poi quelli con scalo
    
            // dd($voli_trovati);
            // controllo se sono stati trovati voli
            if(count($voli_trovati) != 0) {
                // richiamo la funzione voloEconomico per trovare il volo
                // più economico tra quelli trovati
                $voloEconomico = $this->voloEconomico($voli_trovati);
            } else {
                // se non sono stati trovati voli ritorno un array vuoto
                $voloEconomico = [];
            }

            return view('result', compact('voloEconomico'));
        }
    }
}
