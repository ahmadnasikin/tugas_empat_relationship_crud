@extends("layouts.application")

@section("content")

{{Form::model($gallery, array('route' => array('galleries.update', $gallery->id), 'method' => 'PUT', 'class' => 'form-horizontal', 'role' => 'form'))}}

  <div class="form-group">

    {{Form::label('title', 'Title', array('class' => 'col-lg-3 control-label'))}}

    <div class="col-lg-9">

      {{Form::text('title', null, array('class' => 'form-control', 'autofocus' => 'true'))}}

      {{$errors->first('title')}}

    </div>

    <div class="clear"></div>

  </div>


  <div class="form-group">

    {{Form::label('img', 'Select a Picture', array('class' => 'col-lg-3 control-label'))}}

    <div class="col-lg-9">

      {{Form::text('img_name', null, array('class' => 'form-control'))}}

      {{$errors->first('img_name')}}

    </div>

    <div class="clear"></div>

  </div>


  <div class="form-group">

    <div class="col-lg-3"></div>

    <div class="col-lg-9">

      {{Form::submit('Save', array('class' => 'btn btn-primary'))}}

    </div>

    <div class="clear"></div>

  </div>

{{Form::close()}}

@stop
