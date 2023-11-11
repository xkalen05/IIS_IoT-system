<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        .box{
            display: flex;
            flex-direction: column;
            margin: auto;
            width: 300px;
            text-align: left;
        }
        .box-content{
            display: flex;
            flex-direction: column;
        }
        .box-inner{
            padding-top: 5px;
            overflow: hidden;
        }
        .box-inner a{
            float: left;
        }
        .box-inner button{
            float: right;
        }
        .cont-without-reg{
            display: block;
            text-align: center;
            padding-top: 10px;
        }
        .error-box, .success-box{
            margin-left: auto;
            margin-right: auto;
            align-content: center;
            width: fit-content;
            padding: 5px;
            margin-top: 5px;
            border-radius: 5px;
        }

        .error-box{
            background-color: #ff4d4d;
            border: solid 3px red;
        }

        .success-box{
            background-color: greenyellow;
            border: solid 3px green;
        }
    </style>

    <title>IIS_IoT_system</title>
</head>
<body>
<x-error-icon></x-error-icon>
<x-success-icon></x-success-icon>
@yield('login-reg-body')
</body>
