@extends('layouts.auth')

@section('content')
    <div class="container px-2">
        <div class="row justify-content-center bg-white">
            <div class="col-md-11">
                <h2 class="text">Systems shared with me</h2>
                <div class="row py-4">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col"></div>
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
                                <tr>
    {{--                                <td>{{ $system->id }}</td>--}}
                                    <td>{{ $system->name }}</td>
                                    <td>{{ $system->description }}</td>
                                    <td>{{ $system->admin->name }} {{ $system->admin->surname }} - {{ $system->admin->email }}</td>
                                    <td>
                                        <a href="#"
                                           class="btn btn-primary">Show</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No systems shared with you!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

