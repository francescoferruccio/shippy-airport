@extends('layouts.main_layout')

@section('content')
    <div id=result>
        {{-- @php
            dd($voloEconomico);
        @endphp --}}
        @if ($voloEconomico)
            <h2>Ecco il volo più economico per te</h2>
            <h3>Partenza da {{ $departure['name'] }} - {{ $voloEconomico['code_departure'] }}</h3>
            @if ($scalo)
                <h3>Scalo a {{ $scalo['name'] }} - {{ $voloEconomico['code_scalo'] }}</h3>            
            @endif
            <h3>Arrivo a {{ $arrival['name'] }} - {{ $voloEconomico['code_arrival'] }}</h3>
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