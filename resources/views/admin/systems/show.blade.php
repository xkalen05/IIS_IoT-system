@extends('layouts.auth')

@section('content')
    @include('admin.devices.create')
    @include('admin.devices.reserve')
    <h1>{{$system->name}}</h1>
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
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($devices as $device)
                            @include('admin.devices.edit', ['device' => $device])
                            <tr>
                                <td>{{ $device->name }}</td>
                                <td>{{ $device->description }}</td>
                                <td>{{ $device->alias }}</td>
                                <td>
                                    <button type="button" class="btn btn-success"
                                            data-bs-toggle="modal" data-bs-target="#edit_device_{{$device->id}}_modal">
                                        Edit
                                    </button>
                                    <a href="{{route('admin.device.free', $device->id)}}"
                                       class="btn btn-danger">Free</a>
                                </td>
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
