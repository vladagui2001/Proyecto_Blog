<!--<html>
    <head>
        <title>

         </title>
    </head>
    <body>
       <p>Hola mundo desde mi primer vista Ricardo Aldair Puente Reyes</p>
    </body>
</html> -->

<!-- Añadido el 27-09-22 -->
@extends('layouts.app')
@section('title','Trainers')
@section('content')
@csrf
    <p>Listado de trainers</p>
    @foreach ($trainers as $trainer)
    <p>{{$trainer->name}}</p>
@endforeach
@endsection
