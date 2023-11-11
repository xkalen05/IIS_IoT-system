@extends('include.login-reg')
@section('login-reg-body')
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
    <a href="/registration" class="cont-without-reg">Registration</a>
    <a href="/unregistred" class="cont-without-reg">Continue without registration</a>
@endsection
