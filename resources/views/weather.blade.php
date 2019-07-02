@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $cityName }}</div>

                    <div class="panel-body">
                    @isset($factData)
                        Температура: {{ $factData->getTemp() }}°
                    @else
                        Не удалось получить данные о погоде
                    @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
