@extends('layouts.app')

@section('content')
  <h1>Users</h1>

  <center>
    {!! $users->render() !!}
  </center>

  @if (!count($users))
    <br>
    <div class="alert alert-info">You have no users yet</div>
  @endif

  @foreach ($users as $user)
    <div>
      <h4>
        {{$user->name}}
      @if ($user->is_admin)
        <span class="label label-success">Admin</span>
      @endif
      </h4>
      <h5>Added on {{$user->created_at}}</h5>
      <p>{{$user->email}}</p>
      <br>
      <a href="/admin/users/{{$user->slug}}">View</a>
    </div>
    <br>
  @endforeach

  <center>
    {!! $users->render() !!}
  </center>
@endsection
