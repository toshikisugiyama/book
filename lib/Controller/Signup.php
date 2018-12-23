<?php

namespace MyApp\Controller;

class Signup extends \MyApp\Controller {

  public function run() {
    if ($this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // var_dump($_POST);
    // var_dump(exif_imagetype($_FILES['profile-image']['tmp_name']));
    // var_dump($_FILES);
    // exit;
      $this->postProcess();
    }
  }

  protected function postProcess() {
    //validate
    try {
      $this->_validate();
      $ext = $this->_validateImageType();
      $profileImage = sprintf(
        '%s_%s.%s',
        time(),
        sha1(uniqid(mt_rand(), true)),
        $ext
      );
      $savePath = PROFILE_IMAGES_DIR . '/' . $profileImage;
      $res = move_uploaded_file($_FILES['profile-image']['tmp_name'], $savePath);
      // var_dump($savePath);
      // exit;
      $this->_save($res);
    } catch (\MyApp\Exception\InvalidName $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('name', $e->getMessage());
    } catch (\MyApp\Exception\InvalidProfileImage $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('profile-image', $e->getMessage());
    } catch (\MyApp\Exception\InvalidEmail $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('email', $e->getMessage());
    } catch (\MyApp\Exception\InvalidPassword $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('password', $e->getMessage());
    }
    // echo "success";
    // exit;
    $this->setValues('name', $_POST['name']);
    $this->setValues('email', $_POST['email']);

    if ($this->hasError()) {
      return;
    } else {
        // var_dump($this->getValues());
        // exit;
      //create user
      try {
        $userModel = new \MyApp\Model\User();
        // var_dump(basename(pathinfo(PROFILE_IMAGES_DIR)['dirname']).'/'.basename(PROFILE_IMAGES_DIR) . '/' . $profileImage);
        // exit;
        $userModel->create([
          'name' => $_POST['name'],
          'profile_image' => basename(pathinfo(PROFILE_IMAGES_DIR)['dirname']).'/'.basename(PROFILE_IMAGES_DIR) . '/' . $profileImage,
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }
      //redirect to login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }
  }

  private function _save($res) {
    if ($res === false) {
      throw new \MyApp\Exception\InvalidProfileImage('アップロードできませんでした');
    }

    $this->_validateUpload();
    // var_dump($_FILES['profile-image']['error']);
    // exit;
  }

  private function _validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "トークンが無効です";
      exit;
    }
    if ($_POST['name'] === '') {
      throw new \MyApp\Exception\InvalidName();
    }
    if (!isset($_FILES['profile-image']) || !isset($_FILES['profile-image']['error'])) {
      throw new \MyApp\Exception\InvalidProfileImage();
    }
    // var_dump($ext);
    // exit;
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new \MyApp\Exception\InvalidEmail();
    }
    if (!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password']) || mb_strlen($_POST['password']) < 4 || mb_strlen($_POST['password']) > 16) {
      throw new \MyApp\Exception\InvalidPassword();
    }
  }

  private function _validateImageType() {
    $image_type = exif_imagetype($_FILES['profile-image']['tmp_name']);
    // var_dump($image_type);
    // exit;
    switch ($image_type) {
      case IMAGETYPE_GIF:
        return 'gif';
        break;
      case IMAGETYPE_JPEG:
        return 'jpg';
        break;
      case IMAGETYPE_PNG:
        return 'png';
        break;
      default:
      // var_dump($image_type);
      // exit;
        throw new \MyApp\Exception\InvalidProfileImage("GIF/JPG/PNGファイルのみです");
        break;
    }
  }

  private function _validateUpload() {
    switch ($_FILES['profile-image']['error']) {
      case UPLOAD_ERR_OK:
      // var_dump($_FILES['profile-image']['error']);
      // exit;
        return true;
        break;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new \MyApp\Exception\InvalidProfileImage("サイズが大き過ぎます");
        break;
      case UPLOAD_ERR_NO_FILE:
        throw new \MyApp\Exception\InvalidProfileImage("ファイルはアップロードされませんでした");
        break;
      default:
        throw new \MyApp\Exception\InvalidProfileImage("エラー");
        break;
    }
  }
}