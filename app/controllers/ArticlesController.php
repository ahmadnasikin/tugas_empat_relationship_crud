<?php

class ArticlesController extends \BaseController {
        
        
        public function __construct() {

        $this->beforeFilter('auth');

        }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	protected $layout = 'layouts.application';

	public function index()
	{
		$articles = Article::paginate(10);//->toJson();


            if (Request::ajax()) {

             return Response::json(View::make('articles.list', array('articles' => $articles))->render());


            } 

            return View::make('articles.index')->with('articles', $articles);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('articles.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validate = Validator::make(Input::all(), Article::valid());

                  if($validate->fails()) {

                    return Redirect::to('articles/create')

                    ->withErrors($validate)

                    ->withInput();

                  } else {

                    $article = new Article;

                    $article->title = Input::get('title');

                    $article->content = Input::get('content');

                    $article->author = Input::get('author');

                    $article->save();

                    Session::flash('notice', 'Success add article');

                    return Redirect::to('articles');

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
		$article = Article::find($id);

            $comments = Article::find($id)->comments->sortBy('Comment.created_at');

            return View::make('articles.show')

              ->with('article', $article)

              ->with('comments', $comments);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$article = Article::find($id);

    return View::make('articles.edit')

      ->with('article', $article);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validate = Validator::make(Input::all(), Article::valid($id));

	    if($validate->fails()) {

	      return Redirect::to('articles/'.$id.'/edit')

	        ->withErrors($validate)

	        ->withInput();

	    } else {

	      $article = Article::find($id);

	      $article->title = Input::get('title');

	      $article->content = Input::get('content');

	      $article->author = Input::get('author');

	      $article->save();

	      Session::flash('notice', 'Success edit article');

	      return Redirect::to('articles');

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
		$article = Article::find($id);

	    $article->delete();

	    

	    Session::flash('notice', 'Article success deleted');

	    return Redirect::to('articles');
	}




}
