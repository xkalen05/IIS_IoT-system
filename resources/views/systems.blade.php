@extends('include.default')
@section('default-site-body')
    {{Auth::user()}} <!-- Just prints info about user, remove if not using -->
@endsection
