@extends('layouts.app')

@section('content')
  <div style="width: 60%; margin: auto;">
    <h1>User</h1>

    {!! Form::open([
      'method'=>'put',
      'action'=>['UsersController@update'],
      'files'=>true]) 
    !!}
      <div class="form-group">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', $user->name, ['class'=>'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::email('email', $user->email, ['class'=>'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('password', 'Password:') !!}
        <p>
          {!! Form::password('password', null, ['class'=>'form-control']) !!}
        </p>
      </div>
      <div>
        {!! Form::submit('Save', ['class'=>'btn btn-success']) !!}
      </div>
    {!! Form::close() !!}

    @if (count($errors))
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if ($updated)
      <br>
      <div class="alert alert-success">
        User updated successfully.
      </div>
    @endif
  </div>
@endsection
