@extends('layouts.auth')

@section('content')
    @include('admin.systems.create')
    @include('admin.sharing_requests.sharing-requests')

    <div class="container px-2">
        <div class="row justify-content-center bg-white">
            <div class="col-md-11">
                <h2 class="text">Systems Overview</h2>
                <div class="row py-4">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col">
                        <button
                            type="button"
                            class="btn btn-secondary float-md-end"
                            data-bs-toggle="modal"
                            data-bs-target="#sharing_requests_modal"
                        >
                            Sharing requests
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary float-md-end"
                            data-bs-toggle="modal"
                            data-bs-target="#create_system_modal"
                        >
                            Create System
                        </button>
                    </div>
                </div>
                <div class="row py-2">
                    <table class="table table-light">
                        <thead>
                        <tr>
{{--                            <th scope="col">ID</th>--}}
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Owner</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($systems as $system)
                            @include('admin.systems.edit', ['system' => $system])
                            <tr>
{{--                                <td>{{ $system->id }}</td>--}}
                                <td>{{ $system->name }}</td>
                                <td>{{ $system->description }}</td>
                                <td>{{ $system->admin->name }} {{ $system->admin->surname }}</td>
                                <td>
                                    <a href="{{route('admin.system.show', $system->id) }}" class="btn btn-dark">Show Devices</a>
                                    <button
                                        type="button"
                                        class="btn btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#edit_system_{{$system->id}}_modal"
                                    >
                                        Edit
                                    </button>
                                    @include('admin.systems.share', ['system' => $system])
                                    <button
                                        type="button"
                                        class="btn btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#share_system_{{$system->id}}_modal"
                                    >
                                        Share
                                    </button>
                                    <a href="{{route('admin.system.delete', $system->id)}}"
                                       class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>No systems found!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

