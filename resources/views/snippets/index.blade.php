@extends('layouts.app')

@section('content')
  <div style="width: 60%; margin: auto;">
    <h1>Snippets</h1>
    
    {!! $snippets->render() !!}

    @foreach ($snippets as $snippet)
      <div>
        <h4>{{$snippet->title}}</h4>
        <h5>Added on {{$snippet->created_at}}</h5>
        <p>{{$snippet->description}}</p>
        <a href="/snippets/{{$snippet->id}}">View</a>
      </div>
      <br>
    @endforeach

    {!! $snippets->render() !!}
  </div>
@endsection
