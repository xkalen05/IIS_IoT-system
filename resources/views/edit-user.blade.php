@extends('include.default')
@section('default-site-body')
    <div class="edit-user-div">
        <h1>Edit User</h1>
        <h3>email:{{$user_info['email']}}</h3>
        <form method="POST" action="{{route('edit-user.post')}}">
            @csrf
            <input type="hidden" id="email" name="email" value="{{$user_info['email']}}">
            <label for="password">new password:</label><br>
            <input type="text" id="password" name="password" value=""><br>
            <label for="admin">type of user:</label><br>
            <select name="admin" id="admin">
            @if($user_info['admin'] === 1)
                <option name="admin" id="admin" value=1 selected>admin</option>
                <option name="admin" id="admin" value=0>user</option>
            @else
                <option name="admin" id="admin" value=1>admin</option>
                <option name="admin" id="admin" value=0 selected>user</option>
            @endif
            </select><br>
            <button type="submit">EDIT USER</button>
        </form>
    </div>
@endsection
