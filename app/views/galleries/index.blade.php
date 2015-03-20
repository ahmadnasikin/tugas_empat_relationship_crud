@extends("layouts.application")

  @section("content")

       
      @foreach ($galleries as $gallery)
      
       

    <div class="col-lg-3">
  {{ HTML::image('upload_image/thumb/'.$gallery->img, $gallery->img,array('enctype'=>'multipart/form-data','data-toggle'=>'modal','data-target'=>'#myModal', "onclick" => "thumbimage($gallery->id)")) }}
  
    <h1>{{$gallery->title}}</h1>

      <div>

      {{link_to('galleries/'.$gallery->id, 'Show', array('class' => 'btn btn-info'))}}

      {{link_to('galleries/'.$gallery->id.'/edit', 'Edit', array('class' => 'btn btn-warning'))}}

      {{ Form::open(array('route' => array('galleries.destroy', $gallery->id), 'method' => 'delete')) }}

        {{ Form::submit('Delete', array('class' => 'btn btn-danger', "onclick" => "return confirm('are you sure?')")) }}

      {{ Form::close() }}

      </div>

    </div>

  @endforeach
 <div id="gambar-show">
 
 </div>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
        <script>
            function thumbimage($id){
            
                    $.ajax({
                        url: '/galleries/'+ $id,   
                        type: "GET",
                        dataType:"json",   
                        success: function(data){
                            $('#gambar-show').html(data).show();
                            //alert(data);
                            
                        
                        }
                    });
                
            }


        </script>
  
     
@stop
