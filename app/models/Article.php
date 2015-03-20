<?php

class Article extends \Eloquent {
	protected $fillable = [];
	
	public static function valid() {

    return array(

      'content' => 'required'

     );

  }


  public function comments() {

    return $this->hasMany('Comment', 'article_id');

  }
}
