<?php

class Comment extends \Eloquent {
	protected $fillable = [];
	
      public static function valid($id='') {

      return array(

        'content' => 'required|min:30|unique:articles,content'.($id ? ",$id" : ''),

        'user' => 'required'


 
      );
      }
      
      public function articles() {
      return $this->belongsTo('Article', 'article_id');
      }
      
      
}
