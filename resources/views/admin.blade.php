@extends('include.default')
@section('default-site-body')
    <table class="info-table">
        <x-table-component-admin :login="'EMAIL'" :editable="0" :header="1"></x-table-component-admin>
        @isset($users)
            @foreach($users as $user)
                <x-table-component-admin :login="$user"></x-table-component-admin>
            @endforeach
        @endisset
    </table>
@endsection
