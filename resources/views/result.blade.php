@extends('layouts.main_layout')

@section('content')
    <div id=result>
        {{-- @php
            dd($voloEconomico);
        @endphp --}}
        @if ($voloEconomico)
            <h2>Ecco il volo più economico per te</h2>
            <h3>Partenza da {{ $voloEconomico['name_departure'] }} - {{ $voloEconomico['code_departure'] }}</h3>
            {{-- se c'è uno scalo --}}
            @if (array_key_exists('code_scalo', $voloEconomico))
                <h3>Scalo a {{ $voloEconomico['name_scalo'] }} - {{ $voloEconomico['code_scalo'] }}</h3>            
            @endif
            <h3>Arrivo a {{ $voloEconomico['name_arrival'] }} - {{ $voloEconomico['code_arrival'] }}</h3>
            <h3>Prezzo volo: {{ $voloEconomico['price'] }}</h3>
        @else
            <h3>Nessun volo trovato per la destinazione selezionata.</h3>
        @endif
        <div id='new-search'>
            <h4>
                <a href={{ route('home') }}>CERCA UN ALTRO VOLO</a>
            </h4>
        </div>
    </div>
@endsection