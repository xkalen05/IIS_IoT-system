@extends('include.login-reg')
@section('login-reg-body')
    {{Auth::user()}}
@endsection
