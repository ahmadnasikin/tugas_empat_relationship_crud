<?php

class Gallery extends \Eloquent {
	protected $fillable = [];
	
	public static function valid($id='') {

      return array(

        'title' => 'required|min:10|unique:galleries,title'.($id ? ",$id" : ''),

 
      );

    }
}
