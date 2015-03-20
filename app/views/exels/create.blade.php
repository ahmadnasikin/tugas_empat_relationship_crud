@extends("layouts.application")

@section("content")

{{Form::open(array('url' => 'uploadxls', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST', 'enctype' => 'multipart/form-data'))}}


  <div class="form-group">

    {{Form::label('exel', 'Select a File', array('class' => 'col-lg-3 control-label'))}}

    <div class="col-lg-9">

      {{Form::file('exel_name', null, array('class' => 'form-control'))}}

      {{$errors->first('exel_name')}}

    </div>

    <div class="clear"></div>

  </div>


  <div class="form-group">

    <div class="col-lg-3"></div>

    <div class="col-lg-9">

      {{Form::submit('Import', array('class' => 'btn btn-primary'))}}

    </div>

    <div class="clear"></div>

  </div>

{{Form::close()}}

@stop
