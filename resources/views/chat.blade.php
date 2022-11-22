<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .list-group {
            overflow-y: scroll;
            height: 250px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row" id="app">
   @auth
          <chat></chat>
        @endauth
        @guest
            <register-user></register-user>
        @endguest
    </div>
</div>
<script >

</script>
<script src="{{mix('js/app.js')}}"></script>
</body>
