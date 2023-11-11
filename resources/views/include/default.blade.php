<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        /* Predefined site style */
        body{
            margin: 0px;
        }

        .menu{
            padding: 5px;
            background-color: #44BCFF;
        }

        .menu a{
            display: inline;
            text-decoration: none;
            padding: 5px;
        }

        .logout-button{
            float: right;
            padding: 5px;
        }

        .info-table{
            min-width: 500px;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 50px;
            border-collapse: collapse;
            border: none;
        }

        .info-table td{
            border-top: 2px solid white;
        }

        th{
            padding: 5px;
        }

        td{
            padding: 2px 0 2px 5px;
        }

        tr{
            background-color: #718096;
        }

        th:nth-child(odd){
            text-align: left;
        }

        td:nth-child(even){
            text-align: center;
        }

        .edit-user-div{
            margin: auto;
            width: fit-content;
        }

        .error-box{
            margin-left: auto;
            margin-right: auto;
            align-content: center;
            width: fit-content;
            padding: 5px;
            background-color: #ff4d4d;
            margin-top: 5px;
            border-radius: 5px;
            border: solid 3px red;
        }

    </style>

    <title>IIS_IoT_system</title>
</head>
<body>
    <div class="menu">
        <!-- Back button removed, no usage-->
        <a href="/systems">Systems</a>
        @if(Auth::user()['admin'] === 1)
            <a href="/admin">Admin site</a>
        @endif
        <a class="logout-button" href="/logout">Logout</a>
    </div>
    @if(session()->has('error'))
        <div class="error-box">
            <a>{{session('error')}}</a>
        </div>
    @endif
    @if(session()->has('success'))
        <div class="success-box">
            <a>{{session('success')}}</a>
        </div>
    @endif
@yield('default-site-body')
</body>
