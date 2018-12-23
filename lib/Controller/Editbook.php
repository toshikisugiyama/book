<?php
namespace MyApp\Controller;

class Editbook extends \MyApp\Controller {

  public function run() {
      // var_dump($_FILES);
      // var_dump($_POST);
      // exit;
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

      $ext = $this->_validateImageType();
      $bookImage = sprintf(
        '%s_%s.%s',
        time(),
        sha1(uniqid(mt_rand(), true)),
        $ext
      );
      $savePath = BOOK_IMAGES_DIR . '/' . $bookImage;
      $res = move_uploaded_file($_FILES['upfile']['tmp_name'], $savePath);
      // var_dump($res);
      // exit;

    } catch (\MyApp\Exception\InvalidTitle $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('title', $e->getMessage());
    } catch (\MyApp\Exception\InvalidBookImage $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('upfile', $e->getMessage());
    } catch (\MyApp\Exception\InvalidReason $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('reason', $e->getMessage());
    }

    if ($this->hasError()) {
      return;
    } else {
      //edit Books
      $bookModel = new \MyApp\Model\Book();
      $this->setValues('books', $bookModel->find());
      // var_dump($this->getValues());
      // exit;
      $bookModel->edit([
        'title' => $_POST['title'],
        'image' => basename(pathinfo(BOOK_IMAGES_DIR)['dirname']).'/'.basename(BOOK_IMAGES_DIR) . '/' . $bookImage,
        'reason' => $_POST['reason']
      ]);
    }

    header("Location: " . SITE_URL . '/');
  }

  private function _validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "トークンが無効です";
      exit;
    }
    if ($_POST['title'] === '') {
      throw new \MyApp\Exception\InvalidTitle("タイトルを入力してください");
    }
    if ($_FILES['upfile']['name'] === '') {
      throw new \MyApp\Exception\InvalidBookImage("画像を選択してください");
    }
    if ($_POST['reason'] === '') {
      throw new \MyApp\Exception\InvalidReason("おすすめの理由を入力してください");
    }
  }


  private function _validateImageType() {
    if ($_FILES['upfile'] !== []) {
      $image_type = exif_imagetype($_FILES['upfile']['tmp_name']);
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
          throw new \MyApp\Exception\InvalidBookImage("GIF/JPG/PNGファイルのみです");
          break;
      }
    }
  }

}