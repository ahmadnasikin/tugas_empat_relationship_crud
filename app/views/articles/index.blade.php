@extends("layouts.application")

@section("content")

  <h1>article page</h1>

  @if (Session::has('notice')) <div class="alert alert-info">{{Session::get('notice')}}</div> @endif

  @if (Session::has('error')) <div class="alert alert-danger">{{Session::get('error')}}</div> @endif

  <div>{{link_to('articles/create', 'Write Article', array('class' => 'btn btn-success'))}}
  {{link_to('exels/create', 'Import File Exel', array('class' => 'btn btn-success'))}}</div>

  <div id="list-article">

    @include('articles.list')

  </div>
 

@stop


