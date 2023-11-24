@extends('layouts.auth')

@section('content')
    @include('admin.parameters.create')
    <h1>***DEVICE NAME***</h1>
    <!--<h2>{$device}}</h2>-->
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
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($info['parameters'] as $param)
                            @include('admin.parameters.edit', ['param' => $param])
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
                                    <a href="{{route('admin.parameters.delete', $param->id)}}"
                                       class="btn btn-danger">Delete</a>
                                </td>
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
