<?php

class SessionsController extends \BaseController {

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
		return View::make('sessions.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$valid = array(

              'username' => 'required',

              'password' => 'required'

            );

            $validate = Validator::make(Input::all(), $valid);

            if($validate->fails()) {

              return Redirect::to('sessions/create')

                ->withErrors($validate)

                ->withInput();

            }

            if(Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')), (Input::get('remember') ? true : false))) {

              Session::flash('notice', 'Login Success,'.Input::get('username'));

              return Redirect::to('/');

              } else {

                Session::flash('error', 'Login Fails, User or Password is wrong.');

                return Redirect::to('sessions/create')

                  ->withInput();

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
		Auth::logout();

            Session::flash('notice', 'Success Logout');

            return Redirect::to('/');
	}

       
}
