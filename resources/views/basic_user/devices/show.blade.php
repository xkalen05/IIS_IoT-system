@extends('layouts.auth')

@section('content')
    @include('basic_user.parameters.create')
    @foreach($info['device'] as $device)
        <h2>Device: {{$device->name}}</h2>
    @endforeach
    <div class="container px-2">
        <div class="row justify-content-center bg-white">
            <div class="col-md-11">
                <div class="row py-4">
                    <div class="col"></div>
                    <div class="col"></div>
                    <div class="col">
                        <button
                            type="button" class="btn btn-primary float-md-end" data-bs-toggle="modal"
                            data-bs-target="#create_parameter_modal">
                            Add Parameter
                        </button>
                    </div>
                </div>
                <div class="row py-2">
                    <table class="table table-light">
                        <thead>
                        <tr>
                            <th scope="col">Parameter ID</th>
                            <th scope="col">Type</th>
                            <th scope="col">KPI</th>
                            <th scope="col">Actions</th>
                            <th scope="col" class="text-center">State</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($info['parameters'] as $param)
                            @include('basic_user.parameters.edit', ['param' => $param])
                            @include('basic_user.parameters.show', ['param' => $param])
                            @include('basic_user.parameters.show_kpi', ['param' => $param])
                            <tr>
                                <td>{{ $param->id }}</td>
                                <td>{{ $param->name }}</td>
                                <td>{{ $param->kpi_name }}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#edit_parameter_{{$param->id}}_modal"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#show_parameter_{{$param->id}}_modal"
                                    >
                                        Show values
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#show_kpi_parameter_{{$param->id}}_modal"
                                    >
                                        Show KPI rules
                                    </button>
                                    <a href="{{route('user.parameters.delete', $param->id)}}"
                                       class="btn btn-danger">Delete</a>
                                </td>
                                @if($param->result === 0)
                                    <td class="bg-danger text-center">ERROR</td>
                                @else
                                    <td class="bg-success text-center">OK</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td>No parameters found!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
