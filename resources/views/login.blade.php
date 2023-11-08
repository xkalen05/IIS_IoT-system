@extends('include.login-reg')
@section('login-reg-body')
    <div>
        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                @endforeach
            </div>
        @endif

        @if(session()->has('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
        @endif
    </div>
    <form action="{{route('login.post')}}" method="POST">
        @csrf
        <div class="box">
            <h1>IIS IoT system</h1>
            <div class="box-content">
                <label class="email-label">email:</label>
                <input type="text" name="email" value="{{$email ?? ""}}" required aria-label="email-label"/>
            </div>
            <div class="box-content">
                <label class="pwd-label">password:</label>
                <input type="password" name="password" value="{{$pwd ?? ""}}" required aria-label="pwd-label">
            </div>
            <div class="box-inner">
                <button type="submit">login</button>
            </div>
        </div>
    </form>
    <a href="registration">Registration</a>
    <a href="unregistred" class="cont-without-reg">Continue without registration</a>
@endsection
