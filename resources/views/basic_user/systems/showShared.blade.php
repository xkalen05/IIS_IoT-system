@extends('layouts.auth')

@section('content')
    <h1>System: {{$system->name}}</h1>
    <div class="container px-2">
        <div class="row justify-content-center bg-white">
            <div class="col-md-11">
                <div class="row py-4">
                    <div class="col"></div>
                    <div class="col"></div>
                </div>
                <div class="row py-2">
                    <table class="table table-light">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Alias</th>
                            <th scope="col">State</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($devices as $device)
                            <tr>
                                <td>{{ $device->name }}</td>
                                <td>{{ $device->description }}</td>
                                <td>{{ $device->alias }}</td>
                                @if($device->result === 0)
                                    <td class="bg-danger text-center">ERROR</td>
                                @else
                                    <td class="bg-success text-center">OK</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td>This system has no devices!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
