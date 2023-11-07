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
    <div class="box">
        <h1>IIS IoT system</h1>
        <a>login:</a>
        <input type="text" name="login" value="{{$login ?? ""}}"/>
        <a>heslo:</a>
        <input type="password" name="pwd" value="{{$pwd ?? ""}}"/>
        <div class="box-inner">
            <a href="registration">Registration</a>
            <button type="submit">login</button>
        </div>
    </div>
    <a href="unregistred" class="cont-without-reg">Continue without registration</a>
</body>
