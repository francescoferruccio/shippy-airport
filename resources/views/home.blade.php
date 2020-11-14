@extends('layouts.main_layout')

@section('content')
    <div id='search'>
        <h2>Dove vuoi andare?</h2>
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </ul>
            </div>
        @endif
        <div>
            <form method="POST" action={{ route('trovaVolo') }}>
                @csrf
                <label for="departure">Partenza:</label>
                <select name="departure">
                    @foreach ($airports as $airport)
                        <option value="{{ $airport['code'] }}">{{ $airport['name'] }} - {{ $airport['code'] }}</option>
                    @endforeach
                </select>
                <label for="arrival">Destinazione:</label>
                <select name="arrival">
                    @foreach ($airports as $airport)
                        <option value="{{ $airport['code'] }}">{{ $airport['name'] }} - {{ $airport['code'] }}</option>
                    @endforeach
                </select>
                <button type="submit">CERCA</button>
            </form>
        </div>
    </div>
@endsection