@extends('layouts.auth')

@section('content')
    <div class="container">
        <h2>Add values</h2>
        <div class="row py-2">
            @if(count($parameters) > 0)
                <table class="table table-light">
                    <thead>
                    <tr>
                        <th scope="col">Parameter ID</th>
                        <th scope="col">Parameter type</th>
                        <th scope="col">KPI name</th>
                        <th scope="col">Owner</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($parameters as $param)
                        @include('broker.edit', ['param' => $param])
                        <tr>
                            <td>{{ $param->id }}</td>
                            <td>{{ $param->type_name }}</td>
                            <td>{{ $param->kpi_name }}</td>
                            <td>{{ $param->email }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-success"
                                    data-bs-toggle="modal"
                                    data-bs-target="#edit_value_{{$param->id}}_modal"
                                >
                                    Edit Value
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>No parameters found!</p>
            @endif
        </div>
    </div>
@endsection
