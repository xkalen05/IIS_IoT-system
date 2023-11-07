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
    </style>

    <title>IIS_IoT_system</title>
</head>
<body>
@yield('login-reg-body')
</body>
