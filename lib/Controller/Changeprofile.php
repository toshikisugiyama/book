<?php
namespace MyApp\Controller;

class Changeprofile extends \MyApp\Controller {

  public function run() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // var_dump($_FILES);
      // var_dump($_POST);
      // exit;
      $this->editProcess();
    }
  }

  protected function editProcess() {
    try {
      $this->_validate();
      // $_POST=[];
      // var_dump($_POST);
      // var_dump($_FILES);
      // exit;
      $ext = $this->_validateImageType();
      // var_dump($ext);
      // exit;
      $userImage = sprintf(
        '%s_%s.%s',
        time(),
        sha1(uniqid(mt_rand(), true)),
        $ext
      );
      $savePath = PROFILE_IMAGES_DIR . '/' . $userImage;
      // var_dump($savePath);
      // exit;
      $res = move_uploaded_file($_FILES['profile_image']['tmp_name'], $savePath);
      // var_dump($savePath);
      // exit;

    } catch (\MyApp\Exception\InvalidName $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('name', $e->getMessage());
    } catch (\MyApp\Exception\InvalidProfileImage $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('profile_image', $e->getMessage());
    } catch (\MyApp\Exception\InvalidEmail $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('email', $e->getMessage());
    } catch (\MyApp\Exception\InvalidPassword $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('password', $e->getMessage());
    }

    if ($this->hasError()) {
      return;
    } else {
      //edit Users
      $userModel = new \MyApp\Model\User();
      $this->setValues('users', $userModel->find());
      // var_dump($this->getValues());
      // exit;
      // var_dump($userImage);
      // exit;
      // var_dump(basename(pathinfo(PROFILE_IMAGES_DIR)['dirname']).'/'.basename(PROFILE_IMAGES_DIR) . '/' . $userImage);
      // exit;
      $userModel->profile([
        'name' => $_POST['name'],
        'profile_image' => basename(pathinfo(PROFILE_IMAGES_DIR)['dirname']).'/'.basename(PROFILE_IMAGES_DIR) . '/' . $userImage,
        'email' => $_POST['email'],
        'password' => $_POST['password']
      ]);
      // if ($user === null) {
      //   echo "変更失敗";
      //   exit;
      // }
    }
    // var_dump($user);
    // var_dump($userModel->find());
    // exit;
    $_SESSION = [];
      header('Location: ' . SITE_URL);
  }

  private function _validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "トークンが無効です";
      exit;
    }
    if ($_POST['name'] === '') {
      throw new \MyApp\Exception\InvalidName("タイトルを入力してください");
    }
    if ($_FILES['profile_image']['name'] === '') {
      throw new \MyApp\Exception\InvalidProfileImage("画像を選択してください");
    }
    if ($_POST['email'] === '') {
      throw new \MyApp\Exception\InvalidEmail("おすすめの理由を入力してください");
    }
    if ($_POST['password'] === '') {
      throw new \MyApp\Exception\InvalidPassword("パスワードを入力してください");
    }
  }


  private function _validateImageType() {
    if ($_FILES['profile_image'] !== []) {
      // var_dump($_FILES['profile_image']);
      // exit;
      $image_type = exif_imagetype($_FILES['profile_image']['tmp_name']);
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
          throw new \MyApp\Exception\InvalidProfileImage("GIF/JPG/PNGファイルのみです");
          break;
      }
    }
  }

}