@extends('layouts.app')
@section('content')
    <h1>This user:</h1>
    <h3>Email: {{$user->email}}</h3>
    <h3>Name: {{$user->name}}</h3>
@endsection