@extends('layouts.auth')

@section('content')
    @include('profile.edit', ['user' => $user])
    <div class="container">
        <h2>User Profile</h2>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                </div>

                <div class="mb-3">
                    <p><strong>Surname:</strong> {{ $user->surname }}</p>
                </div>

                <div class="mb-3">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#edit_user_{{$user->id}}_modal"
        > Edit
        </button>
    </div>
@endsection
