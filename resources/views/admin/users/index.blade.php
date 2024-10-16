@extends('layouts.auth')

@section('content')
    @include('admin.users.create')

    <div class="container px-2">
        <h2 class="text">Users Overview</h2>
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
                            data-bs-target="#create_user_modal"
                        >
                            Create User
                        </button>
                    </div>
                </div>
                <div class="row py-2">
                    @if(count($users) > 0)
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
                            @foreach($users as $user)
                                @include('admin.users.edit', ['user' => $user])
                                @include('admin.users.change-password', ['$user' => $user])
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
                                            <button
                                            type="button"
                                            class="btn btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#edit_user-password_{{$user->id}}_by_admin_modal"
                                        >
                                            Change password
                                        </button>
                                        <a href="{{route('admin.user.delete', $user->id)}}"
                                           class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No users found!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
