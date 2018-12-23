<?php

namespace MyApp\Controller;

class Page extends \MyApp\Controller {

  public function show() {
    $bookModel = new \MyApp\Model\Book();
    $res = $bookModel->page();
    return $res;
    // var_dump($res);
  }

}