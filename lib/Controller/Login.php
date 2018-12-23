<?php

namespace MyApp\Controller;

class Login extends \MyApp\Controller {

  public function run() {
    if ($this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }

  protected function postProcess() {
    try {
      $this->_validate();
    } catch (\MyApp\Exception\EmptyPost $e) {
      $this->setErrors('login', $e->getMessage());
    }

    $this->setValues('name', $_POST['name']);
    $this->setValues('email', $_POST['email']);

    if ($this->hasError()) {
      return;
    } else {
      try {
        $userModel = new \MyApp\Model\User();
        $user = $userModel->login([
          'name' => $_POST['name'],
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\UnmatchLogIn $e) {
        $this->setErrors('login', $e->getMessage());
        return;
      }

      //login処理
      session_regenerate_id(true);
      $_SESSION['me'] = $user;

      //redirect to home
      header('Location: ' . SITE_URL);
      exit;
    }

  }

  private function _validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "トークンが無効です";
      exit;
    }
    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password'])) {
      echo "フォームが無効です";
      exit;
    }
    if ($_POST['name'] === '' || $_POST['email'] === '' || $_POST['password'] === '') {
      throw new \MyApp\Exception\EmptyPost();
    }
  }
}