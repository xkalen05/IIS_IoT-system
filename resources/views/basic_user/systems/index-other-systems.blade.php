@extends('layouts.auth')

@section('content')

    <div class="container px-2">
        <div class="row justify-content-center bg-white">
            <div class="col-md-11">
                <div class="row py-4">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col"></div>
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
                        @foreach($otherSystems as $system)
                            <tr>
{{--                                <td>{{ $system->id }}</td>--}}
                                <td>{{ $system->name }}</td>
                                <td>{{ $system->description }}</td>
                                <td>{{ $system->admin->name }} {{ $system->admin->surname }}</td>
                                <td>
                                    @if(!\App\Models\SystemSharingRequest::hasPendingRequest($system->id, auth()->id()))
                                        <a href="{{ route('user.system.share.request', $system->id) }}"
                                           class="btn btn-outline-warning">Share Request</a>
                                    @else
                                        <button class="btn btn-outline-warning" disabled>Pending Request</button>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

