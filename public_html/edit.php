<?php

//新規会員登録
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Index();
// $app->run();

$addbook = new MyApp\Controller\Addbook();
// $addbook->run();
// var_dump($_GET);
// exit;
$bookModel = new \MyApp\Model\Book();
// $bookModel->find();
// var_dump($bookModel->find());
// exit;
$editbook = new MyApp\Controller\Editbook();
$editbook->run();

// var_dump($_GET);
// echo h($bookModel->find());
// exit;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>編集</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shitajicss@5.0.0/docs/css/shitaji.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1 class="title"><a href="/">Shoseki Uploader</a></h1>
    <form class="logout" action="logout.php" method="post" id="logout">
      <a href="/profile.php"><img src="<?= h($app->me()->profile_image); ?>" alt="プロフィール画像"><span><?= h($app->me()->name); ?></span></a>
      <input class="button" type="submit" value="ログアウト">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
  </header>
  <main>
    <div class="container">
      <h1 class="title">編集</h1>
      <?php if (isset($error)): ?>
        <p class="err"><?= h($error); ?></p>
      <?php endif ?>
      <form action="" method="POST" enctype="multipart/form-data">
        <p>
          <input type="text" name="title" placeholder="タイトル" value="<?= h($bookModel->find()['title']); ?>" autocomplete="off">
        </p>
        <p class="err"><?= h($editbook->getErrors('title')); ?></p>
        <p>
          <input type="hidden" name="MAX_FILE_SIZE" value="<?= h(MAX_FILE_SIZE); ?>">
          <input class="profile-image" type="file" name="upfile" accept="image/*" capture="camera" value="<?= h($bookModel->find()['image']); ?>">
        </p>
        <p class="err"><?= h($editbook->getErrors('upfile')); ?></p>
        <p>
          <input type="text" name="reason" placeholder="おすすめの理由" value="<?= h($bookModel->find()['reason']); ?>" autocomplete="off">
        </p>
        <p class="err"><?= h($editbook->getErrors('reason')); ?></p>
        <p>
          <input class="login button" type="submit" value="変更">
        </p>
        <p class="err"><?= h($app->getErrors('login')); ?></p>
        <p>
          <a class="link" href="/">戻る</a>
        </p>
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      </form>
    </div>
  </main>
  <footer></footer>
</body>
</html>