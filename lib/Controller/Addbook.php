<?php
namespace MyApp\Controller;

class Addbook extends \MyApp\Controller {

  public function run() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // var_dump($this->getValues());
    // exit;
      $this->addProcess();
    }

    $bookModel = new \MyApp\Model\Book();
    // $this->setValues('books', $bookModel->findAll());
    $this->setValues('books', $bookModel->show());
  }


  protected function addProcess() {
    //validate
    // var_dump($_POST);
    // var_dump($_FILES);
    // exit;
    try {
      $this->_validate();
      $this->_validateImage();
      $ext = $this->_validateImageType();
      $bookImage = sprintf(
        '%s_%s.%s',
        time(),
        sha1(uniqid(mt_rand(), true)),
        $ext
      );
      $savePath = BOOK_IMAGES_DIR . '/' . $bookImage;
      $res = move_uploaded_file($_FILES['book-image']['tmp_name'], $savePath);
      // var_dump($res);
      // exit;

    } catch (\MyApp\Exception\InvalidTitle $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('title', $e->getMessage());
    } catch (\MyApp\Exception\InvalidBookImage $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('book-image', $e->getMessage());
    } catch (\MyApp\Exception\InvalidReason $e) {
      // echo $e->getMessage();
      // exit;
      $this->setErrors('reason', $e->getMessage());
    }
    // echo "success";
    // exit;
    // var_dump($_FILES);
    // var_dump($_POST);
    // exit;

    if ($this->hasError()) {
      return;
    } else {
      //create Books
      $bookModel = new \MyApp\Model\Book();
      // var_dump($this->me()->id);
      // exit;
      $bookModel->add([
        'title' => $_POST['title'],
        'reason' => $_POST['reason'],
        'image' => basename(pathinfo(BOOK_IMAGES_DIR)['dirname']).'/'.basename(BOOK_IMAGES_DIR) . '/' . $bookImage,
        'contributor_id' => $this->me()->id,
      ]);
    }
    $bookModel->show();
    header("Location: " . SITE_URL . '/');
  }

  private function _validateImage() {
    // var_dump($_FILES['book-image']['error']);
    // exit;
      switch ($_FILES['book-image']['error']) {
        case UPLOAD_ERR_OK:
          return;
          break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
          throw new \MyApp\Exception\InvalidBookImage("画像サイズが大き過ぎます");
          break;
        default:
          throw new \MyApp\Exception\InvalidBookImage("画像アップロードに失敗しました");
          break;
      }
  }

  private function _validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "トークンが無効です";
      exit;
    }
    if ($_POST['title'] === '') {
      throw new \MyApp\Exception\InvalidTitle("タイトルを入力してください");
    }
    if ($_FILES['book-image']['name'] === '') {
      throw new \MyApp\Exception\InvalidBookImage("画像を選択してください");
    }
    if ($_POST['reason'] === '') {
      throw new \MyApp\Exception\InvalidReason("おすすめの理由を入力してください");
    }
  }


  private function _validateImageType() {
    if ($_FILES['book-image'] !== []) {
      $image_type = exif_imagetype($_FILES['book-image']['tmp_name']);
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