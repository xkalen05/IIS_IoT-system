@extends('layouts.auth')

@section('content')
    @include('profile.edit', ['user' => $user])
    <div class="container">
        <h2>User Profile</h2>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" value="{{ $user->name }}" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label for="surname" class="form-label">Surname:</label>
                    <input type="text" value="{{ $user->surname }}" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="text" value="{{ $user->email }}" class="form-control" readonly>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#edit_user_{{$user->id}}_modal"
        > Edit
        </button>
    </div>
@endsection


