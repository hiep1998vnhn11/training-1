@extends('layouts.app')
@section('content')
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
      @if($user->isAdmin)
      @else
      <tr>
      <th scope="row">{{$user->id}}</th>
      <td>{{$user->name}}</td>
      <td>{{$user->email}}</td>
      <td>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
      Delete
      </button>
      <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you want to delete user {{$user->name}}?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="/admin/{{$user->id}}/delete" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Delete</a>

      </div>
    </div>
  </div>
</div>
      </td>
      <td><a href="/admin/{{$user->id}}/edit">Edit</a></td>
      <td><a href="/admin/{{$user->id}}/show">Show</a></td>
      </tr>
      @endif
      @endforeach
      <tr>
        <a href="/admin/create">Create new user</a>
      </tr>
  </tbody>
</table>



@endsection