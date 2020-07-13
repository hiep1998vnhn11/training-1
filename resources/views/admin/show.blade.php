@extends('layouts.app')
@section('content')
    <h1>This user:</h1>
    <h3>{{$user->email}}</h3>
    <h3>{{$user->name}}</h3>
@endsection