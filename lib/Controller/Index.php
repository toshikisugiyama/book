<?php

namespace MyApp\Controller;

class Index extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      //Login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }
  }
}