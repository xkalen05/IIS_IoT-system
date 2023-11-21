@extends('layouts.auth')

@section('content')
    @include('admin.systems.create')

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
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($systems as $system)
                            @include('admin.systems.edit', ['system' => $system])
                            <tr>
                                <td>{{ $system->id }}</td>
                                <td>{{ $system->name }}</td>
                                <td>{{ $system->description }}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#edit_system_{{$system->id}}_modal"
                                    >
                                        Edit
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

