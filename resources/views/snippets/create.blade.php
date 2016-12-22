@extends('layouts.app')

@section('content')
  <div style="width: 60%; margin: auto;">
    <h1>Create Snippet</h1>

    {!! Form::open([
      'method'=>'post',
      'action'=>'SnippetsController@store',
      'files'=>true]) 
    !!}
      <div class="form-group">
        {!! Form::label('title', 'Title:') !!}
        {!! Form::text('title', old('title'), ['class'=>'form-control']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('description', 'Description:') !!}
        {!! Form::textarea('description', old('description'), ['class'=>'form-control', 'style'=>'height: 50px;']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('text', 'Snippet:') !!}
        <p>
          {!! Form::textarea('text', old('text'), ['class'=>'form-control', 'id'=>'snippet']) !!}
        </p>
      </div>
      <div class="form-group">
        {!! Form::label('syntax', 'Syntax:') !!}
        {!! Form::select('syntax', [
          'php' => 'php',
          'java' => 'java',
          'bash' => 'bash',
          'typescript' => 'typescript',
          'python' => 'python',
          'markup' => 'html',
          'css' => 'css',
          'javascript' => 'javascript',
          'markdown' => 'markdown',
          'cpp' => 'c++',
          'c' => 'c',
          'csharp' => 'c#',
          'ruby' => 'ruby',
          'json' => 'json',
          'apacheconf' => 'apacheconf',
          'nginx' => 'nginx',
          'sass' => 'sass',
          'scss' => 'scss',
          'less' => 'less',
          'jade' => 'jade',
          'jsx' => 'jsx',
          'sql' => 'sql',
        ]) !!}
      </div>
      <div class="form-group" id="file-container">
        {!! Form::label('file', 'File:') !!}
        {!! Form::file('file') !!}
      </div>
      <div>
        {!! Form::submit('Create Snippet', ['class'=>'btn btn-success']) !!}
      </div>
    {!! Form::close() !!}

    @if (count($errors))
      <br>
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  <script>
    document.body.addEventListener('click', function(event) {
      if (event.target.id === 'file') {
        var snippet = document.getElementById('snippet');

        snippet.disabled = true;
      }
    });
  </script>
@endsection
