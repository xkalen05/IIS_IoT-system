@extends('layouts.auth')

@section('content')
    @include('admin.users.create')

    <div class="container px-2">
        <div class="row justify-content-center bg-white">
            <div class="col-md-11">
                <h2 class="text">Users Overview</h2>
                <div class="row py-4">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col">
                        <button
                            type="button"
                            class="btn btn-primary float-md-end"
                            data-bs-toggle="modal"
                            data-bs-target="#create_user_modal"
                        >
                            Create User
                        </button>
                    </div>
                </div>
                <div class="row py-2">
                    <table class="table table-light">
                        <thead>
                        <tr>
{{--                            <th scope="col">ID</th>--}}
                            <th scope="col">Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">email</th>
                            <th scope="col">role</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            @include('admin.users.edit', ['user' => $user])
                            <tr>
{{--                                <td>{{ $user->id }}</td>--}}
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->surname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#edit_user_{{$user->id}}_modal"
                                    >
                                        Edit
                                    </button>
                                    <a href="{{route('admin.user.delete', $user->id)}}"
                                       class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>No users found!</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
