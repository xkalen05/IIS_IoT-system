@extends('layouts.auth')

@section('content')
    @include('basic_user.devices.create')
    @include('basic_user.devices.reserve')
    <h1>System: {{$system->name}}</h1>
    <div class="container px-2">
        <div class="row justify-content-center bg-white">
            <div class="col-md-11">
                <div class="row py-4">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col">
                        <button
                            type="button"
                            class="btn btn-primary float-md-end"
                            data-bs-toggle="modal"
                            data-bs-target="#create_device_modal"
                        >
                            Create Device
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-toggle="modal"
                            data-bs-target="#reserve_device_{{$system->id}}_modal"
                        >
                            Add device to system
                        </button>
                    </div>
                </div>
                <div class="row py-2">
                    <table class="table table-light">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Alias</th>
                            <th scope="col">Actions</th>
                            <th scope="col">State</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($devices as $device)
                            @include('basic_user.devices.edit', ['device' => $device])
                            <tr>
                                <td>{{ $device->name }}</td>
                                <td>{{ $device->description }}</td>
                                <td>{{ $device->alias }}</td>
                                <td>
                                    <button type="button" class="btn btn-success"
                                            data-bs-toggle="modal" data-bs-target="#edit_device_{{$device->id}}_modal">
                                        Edit
                                    </button>
                                    <a href="{{route('user.device.show', ['encrypted_id' => encrypt($device->id)]) }}"
                                       class="btn btn-warning">Parameters</a>
                                    <a href="{{route('user.device.free', $device->id)}}"
                                       class="btn btn-danger">Free</a>
                                </td>
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
