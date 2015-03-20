<?php

class exelsController extends \BaseController {


	public function uploadxls(){

			$path="public/upload_xls";
            if(!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
            }
			$file=Input::file('exel_name');
			$name = time()."_".$file->getClientOriginalName();
			$path_file = $path."/".$name;
			
			//simpan picture
			$file->move($path,$name);

			$data = Excel::load($path_file, function($reader) {})->get();

			$article = $data[0]; // Berisi Sheet 1 dari file excel
			$comment = $data[1]; // Berisi Sheet 2 dari file excel

			// echo "<pre>";
			// var_dump($article[0]);
			// exit();

			// Mengimport data article

			foreach ($article as $key => $row) {
				// dd($row);
				$article_table = new Article;

                $article_table->title = $row['title'];

                $article_table->content = $row['content'];

                $article_table->author = $row['author'];

                $article_table->save();
			}
			// echo "<pre>";
			// var_dump($article[0]);
			// exit();

		// exit();

			// Mengimport data Comment
			foreach ($comment as $key => $row) {
				// dd($row);
				$comment_table = new Comment;

				$comment_table->article_id = $row['id_article'];

                $comment_table->content = $row['content'];

                $comment_table->user = $row['user'];

                $comment_table->save();
			}


			Session::flash('notice', 'Success Import Data');

            return Redirect::to('articles');

	}


	public function exportxls($id){

		$article = Article::find($id);

		$comment = Article::find($id)->comments->sortBy('Comment.created_at');

		//$comment = Comment::whereArticle_id($article->id);

		// echo "<pre>";
		// 	var_dump($comment);
		// 	exit();

		$name = $article->title;

		Excel::create($name, function($excel) use($article, $comment){

		    // sheet articles
		    $excel->sheet('Article', function($sheet) use($article, $comment){

		    
		    	// $sheet->mergeCells('A1:D1');//merge for title
       //          $sheet->row(1, function ($row) {
       //              $row->setFontSize(14);
       //          });
       //          $sheet->setHeight(1, 25);
       //          $sheet->row(1, array('Data Article') );//add title
                $sheet->cell('A1','id' );//add title
                $sheet->cell('B1', 'title' );//add title
                $sheet->cell('C1', 'content' );//add title
                $sheet->cell('D1', 'author' );//add title

		    	$a=2;
		    	$sheet->row($a,array($article->id, $article->title, $article->content,$article->author ));

		    });

		    // sheet Comment
		    $excel->sheet('Comment', function($sheet) use($article, $comment) {
		    	
                
			    // $sheet->mergeCells('A1:C1');//merge for title
	      //       $sheet->row(1, function ($row) {
	      //       $row->setFontSize(14);
	      //       });
	      //       $sheet->setHeight(1, 25);
	      //       $sheet->row(1, array('Data Comment Article') );//add title
	            $sheet->cell('A1','id_Article' );//add title
	            $sheet->cell('B1', 'content' );//add title
	            $sheet->cell('C1', 'user' );//add title

	            $b=2;
			    foreach($comment as $comment_article){
			        
			        $sheet->row($b,array($comment_article->article_id, $comment_article->content, $comment_article->user ));//add title
			        $b++;
			    }
	            

		    });

		})->export('xls');



	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('exels.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	    
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
