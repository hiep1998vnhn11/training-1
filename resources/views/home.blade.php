@extends('layouts.app')

@section('content')
@role('blocked')
    <h1> You are blocked!</h1>
@else
  <form class="form-inline" action="/admin/search">
    <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
  </form>
<table class="table">

  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Delete</th>
      <th scope="col">Edit</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
      @foreach($users as $user)
      <tr>
      <th scope="row">{{$user->id}}</th>
      <td>{{$user->name}}</td>
      <td>{{$user->email}}</td>
      <td>
          @role('viewer')
          @else
        <a href="/admin/{{$user->id}}/delete">Delete</a>
        @endrole
      </td>
      <td>
          @role('viewer')
            @if($user->id == $currentUser->id)
            <a href="/admin/{{$user->id}}/edit">Edit</a>
            @endif
          @else 
            <a href="/admin/{{$user->id}}/edit">Edit</a>
          @endrole
        </td>
      <td><a href="/admin/{{$user->id}}/show">Show</a></td>
      </tr>
      @endforeach
      <tr>
        @role('viewer')
        @else
        <a href="/admin/create">Create new user</a>
        @endrole
      </tr>
      <tr>
      @if(session()->has('success'))
        <div class="alert alert-success">
          {{ session()->get('success') }}
        </div>
      @endif
      @if(session()->has('fail'))
        <div class="alert alert-danger">
          {{ session()->get('fail') }}
        </div>
      @endif
      </tr>
  </tbody>
</table>
@endrole
 
@endsection
