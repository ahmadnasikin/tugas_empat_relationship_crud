<?php

class GalleriesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$galleries = Gallery::all();

            return View::make('galleries.index')->with('galleries', $galleries);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('galleries.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validate = Validator::make(Input::all(), Gallery::valid());

                  if($validate->fails()) {

                    return Redirect::to('galleries/create')

                    ->withErrors($validate)

                    ->withInput();

                  } else {
                    
                    //proses simpan data di database
			$img=Input::file('img_name');
			$extension = $img->getClientOriginalExtension();
			$picture = new Gallery;
			$picture->title=Input::get('title');
			$picture->img="nama image";
			$picture->save();

			//nama picture
			$path="public/upload_image";
			$name=$picture->id."_picture.".$extension;
			$picture->img=$name;
			$picture->save();

			//simpan picture
			$img->move($path,$name);
			
			//resize picture for thumbs
			$path_thumbs="public/upload_image/thumb";
			$img = Image::make($path.'/'.$name);
			//$img->resize(200, 100);
			$img->resize(null, 100, function ($constraint) {
    			$constraint->aspectRatio();
			});
			$img->resizeCanvas(200, 100);
			$img->save($path_thumbs.'/'.$name);
			
			//resize picture for thumbs
			$path_shows="public/upload_image/shows";
            if(!File::exists($path_shows)) {
            File::makeDirectory($path_shows, $mode = 0777, true, true);
            }
			
			$img = Image::make($path.'/'.$name);
			//$img->resize(600, 300);
			$img->resize(null, 300, function ($constraint) {
    			$constraint->aspectRatio();
			});
			$img->resizeCanvas(600, 300);
			$img->save($path_shows.'/'.$name);			

			Session::flash('notice','Succes add picture');
			return Redirect::to('galleries');
                  }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$gallery = Gallery::find($id);
		if(Request::ajax())
                {
                    return Response::json(View::make('galleries.show', array('gallery' => $gallery))->render());
                }
                else
                {
                    return View::make('galleries.show')->with('gallery', $gallery);
                }


            
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$gallery = Gallery::find($id);

            return View::make('galleries.edit')

              ->with('gallery', $gallery);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validate = Validator::make(Input::all(), Gallery::valid($id));

            if($validate->fails()) {

             return Redirect::to('galleries/'.$id.'/edit')

             ->withErrors($validate)

             ->withInput();

            } else {

              $gallery = Gallery::find($id);

              $gallery->title = Input::get('title');

              $gallery->img = Input::get('img_name');
              
               if (Input::hasFile('img_name'))
                {
	                $file     = Input::file('img_name');
	                $filename = str_random(25).'-'.$file->getClientOriginalName();

	                $destinationPath = '/public/upload_gambar';
                    $file->move($destinationPath, $filename);

                }


              $gallery->save();

              Session::flash('notice', 'Success update gallery');

              return Redirect::to('galleries');

            }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
            
            $gallery = Gallery::find($id);
             
            $path="upload_image/thumb_".$gallery->id."/".$gallery->img;
            
	    File::delete($path);

            $gallery->delete();

            Session::flash('notice', 'Gallery success delete');

            return Redirect::to('galleries');


	}


}
