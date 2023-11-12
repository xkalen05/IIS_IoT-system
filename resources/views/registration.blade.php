@extends('include.login-reg')
@section('login-reg-body')
    <form action="{{route('registration.post')}}" method="POST">
        @csrf
        <div class="box">
            <h1>Registration</h1>
            <div class="box-content">
                <label class="email-label">your email:</label>
                <input type="text" name="email" value="{{$email ?? ""}}" required aria-label="email-label"/>
            </div>
            <div class="box-content">
                <label class="pwd-label">new password:</label>
                <input type="password" name="password" value="{{$pwd ?? ""}}" required aria-label="pwd-label">
            </div>
            <div class="box-inner">
                <button type="submit">registrate</button>
            </div>
        </div>
    </form>
@endsection
