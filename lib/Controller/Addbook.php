<?php
namespace MyApp\Controller;

class Addbook extends \MyApp\Controller {

  public function run() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->addProcess();
    }

    $bookModel = new \MyApp\Model\Book();
    $this->setValues('books', $bookModel->findAll());
  }

  protected function addProcess() {
    //validate
    try {
      $this->_validate();
      // var_dump($_POST);
      // exit;
    } catch (\MyApp\Exception\InvalidTitle $e) {
      echo $e->getMessage();
      exit;
      $this->setErrors('title', $e->getMessage());
    }
    // echo "success";
    // exit;
    // var_dump($_FILES);
    // var_dump($_POST);
    // exit;

    // POSTではないとき何もしない
    if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') !== 'POST') {
        return;
    }
    // アップロードファイル
    // var_dump($_POST);
    // var_dump($_FILES);
    // exit;
    $upfile = $_FILES['image'];


    
    if ($upfile['error'] > 0) {
        throw new Exception('ファイルアップロードに失敗しました。');
    }

    $tmp_name = $upfile['tmp_name'];

    // ファイルタイプチェック
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimetype = finfo_file($finfo, $tmp_name);

    // 許可するMIMETYPE
    $allowed_types = [
        'jpg' => 'image/jpeg'
        , 'png' => 'image/png'
        , 'gif' => 'image/gif'
    ];
    if (!in_array($mimetype, $allowed_types)) {
        throw new Exception('許可されていないファイルタイプです。');
    }

    // ファイル名
    $filename = sha1_file($tmp_name);

    // 拡張子
    $ext = array_search($mimetype, $allowed_types);

    // 保存作ファイルパス
    $destination = sprintf('%s/%s.%s'
        , 'image'
        , $filename
        , $ext
    );


    // アップロードディレクトリに移動
    if (!move_uploaded_file($tmp_name, $destination)) {
        throw new Exception('ファイルの保存に失敗しました。');
    }


    $this->setValues('title', $_POST['title']);
    $this->setValues('reason', $_POST['reason']);
    $this->setValues('image', $tmp_name);

    var_dump($tmp_name);
    exit;

    if ($this->hasError()) {
      return;
    } else {
      //add book
      try {
        $userModel = new \MyApp\Model\Book();
        $userModel->add([
          'title' => $_POST['title'],
          'reason' => $_POST['reason'],
          'image' => $_POST['image']
        ]);
      } catch (Exception $e) {
        echo "エラー";
        exit;
        throw new Exception('エラー');
      }
      //redirect to index
      header('Location: ' . SITE_URL);
      exit;
    }
  }

  private function _validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "Invalid Token!";
      exit;
    }
  }

}