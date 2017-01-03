@extends('layouts.app')

@section('content')
  <h1>Snippets</h1>

  @if ($is_admin_route)
    <form method="get" action="/admin/snippets">
      <input type="search"
        name="search_term"
        placeholder="Search"
        class="form-control"
        value="{{$search_term}}">
    </form>
  @endif
  
  <center>
    {!! $snippets->render() !!}
  </center>

  @if (!count($snippets))
    <br>
    <div class="alert alert-info">You have no snippets yet</div>
  @endif

  @foreach ($snippets as $snippet)
    <div>
      <h4>{{$snippet->title}}</h4>
      <h5>Added on {{$snippet->created_at}}</h5>
      <p>{{$snippet->description}}</p>
      <small>{{$snippet->syntax}}</small>
      <br>
      <a href="/snippets/{{$snippet->slug}}">View</a>
    </div>
    <br>
  @endforeach

  <center>
    {!! $snippets->render() !!}
  </center>
@endsection
