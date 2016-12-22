@extends('layouts.app')

@section('content')
  @if ($user && $user->theme)
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.6.0/themes/prism-{{$user->theme}}.css" />
  @endif

  <a class="back-arrow" href="{{$back}}"><i class="fa fa-chevron-left"></i> Go Back</a>

  <h1>{{$snippet->title}}</h1>
  <p>Added by {{$snippet->user->name}} on {{$snippet->created_at}}</p>
  <p>{{$snippet->description}}</p>
  <pre class="line-numbers code-view"><code class="language-{{$snippet->syntax}}">{{$snippet->text}}</code></pre>

  {!! Form::open(['method'=>'delete', 'action'=>['SnippetsController@destroy', $snippet->id]]) !!}
    {!! Form::submit('Delete Snippet', ['class'=>'btn btn-danger pull-right']) !!}
  {!! Form::close() !!}

  <a class="back-arrow" href="{{$back}}"><i class="fa fa-chevron-left"></i> Go Back</a>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.6.0/prism.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.6.0/plugins/line-numbers/prism-line-numbers.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.6.0/components/prism-{{$snippet->syntax}}.js"></script>

@endsection
