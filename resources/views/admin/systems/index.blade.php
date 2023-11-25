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
                        <style>
                            @keyframes blink {
                                0% {
                                    opacity: 1;
                                }
                                50% {
                                    opacity: 0;
                                }
                                100% {
                                    opacity: 1;
                                }
                            }
                            .btn-danger.blinking {
                                animation: blink 1s infinite;
                            }
                        </style>
                        <button
                            type="button"
                            class="btn btn-{{ $hasSharingRequests ? 'danger blinking' : 'secondary' }} float-md-end"
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
                    @if(count($systems) > 0)
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
                            @foreach($systems as $system)
                                @include('admin.systems.edit', ['system' => $system])
                                <tr>
                                    {{--                                <td>{{ $system->id }}</td>--}}
                                    <td>{{ $system->name }}</td>
                                    <td>{{ $system->description }}</td>
                                    <td>{{ $system->admin->name }} {{ $system->admin->surname }}</td>
                                    <td>
                                        <a href="{{route('admin.system.show', $system->id) }}" class="btn btn-dark">Show
                                            Devices</a>
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
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No systems found!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

