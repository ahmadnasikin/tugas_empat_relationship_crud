<?php

class ArticlesTest extends TestCase {

  /* This testing Controller Articles

   * All action for Create, Update, Delete, Show

   * Data from Test will direct save to real database

   */


  //TEST ACTION INDEX

  public function testArticleIndex() {

    $this->call('GET', 'articles');

    $this->assertResponseOk(); //this equal with : $this->assertResponseStatus(200); 

    $this->assertViewHas('articles');

  }


  //TEST ACTION CREATE

  public function testArticleCreate() {

    $this->call('GET', 'articles/create');

    $this->assertResponseOk();

  }


  //TEST ACTION STORE (WITH FAILS SCHEM)

  public function testArticleStoreFails() {

    $data = array("title" => "", "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "author" => "Ujang");

    $post = $this->action('POST', 'ArticlesController@store', $data);

    $this->assertRedirectedToRoute('articles.create');

  }


  //TEST ACTION STORE (WITH SUCCESS SCHEM)

  public function testArticleStoreSuccess() {

    $data = array("title" => "Testing Article title ".str_random(10), "content" => str_random(10)." Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "author" => "Ujang");

    $post = $this->action('POST', 'ArticlesController@store', $data);

    $this->assertResponseStatus(302);

    $this->assertRedirectedToRoute('articles.index');

    $this->assertSessionHas('flash');

  }


   //TEST ACTION SHOW

  public function testArticleShow() {

    $article = Article::where('title', 'like', '%Testing Article title%')->first();

    if(empty($article)) {

      $data = array("title" => "Testing Article title", "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "author" => "Ujang");

      $post = $this->action('POST', 'ArticlesController@store', $data);

    }

    $this->action('GET', 'ArticlesController@show', $article->first()->id);

    $this->assertResponseOk();

  }


  //TEST ACTION EDIT

  public function testArticleEdit() {

    $article = Article::where('title', 'like', '%Testing Article title%')->first();

    if(empty($article)) {

      $data = array("title" => "Testing Article title", "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "author" => "Ujang");

      $post = $this->action('POST', 'ArticlesController@store', $data);

    }

    $this->action('GET', 'ArticlesController@edit', $article->first()->id);

    $this->assertResponseOk();

  }


//TEST ACTION UPDATE (WITH FAILS SCHEM)

  public function testArticleUpdateFails() {

    $data = array("title" => "Testing Article title", "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "author" => "Ujang");

    $post = $this->action('POST', 'ArticlesController@store', $data);

    $article = Article::where('title', 'like', 'Testing Article title')->first();

    $update_data = array("title" => "", "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "author" => "Ujang");

    

    $this->call('PUT', 'articles/'.$article->first()->id, $update_data);

    $this->assertRedirectedTo('articles/'.$article->first()->id.'/edit');

  }


//TEST ACTION UPDATE (WITH SUCCESS SCHEM)

  public function testArticleUpdateSuccess() {

    $article = Article::where('title', 'like', 'Testing Article title')->first();

    if(empty($article)) {

      $data = array("title" => "Testing Article title", "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "author" => "Ujang");

      $post = $this->action('POST', 'ArticlesController@store', $data);

    }

    $update_data = array("title" => "Edit Article Testing " . str_random(10), "content" => str_random(10)."Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "author" => "Ujang");

    $this->call('PUT', 'articles/'.$article->first()->id, $update_data);

    $this->assertRedirectedTo('articles');

    $this->assertSessionHas('flash');

  }

}