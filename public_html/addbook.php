<?php

//新規会員登録
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Index();
$app->run();

$addbook = new MyApp\Controller\Addbook();
$addbook->run();
// if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') !== 'POST') {
//         return;
//     }
// var_dump($_FILES);
// exit;


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>HOME</title>
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
      <h1 class="title">おすすめ書籍アップロード</h1>
      <?php if (isset($error)): ?>
        <p class="err"><?= h($error); ?></p>
      <?php endif ?>
      <form method="post" action="" enctype="multipart/form-data">
        <p>
          <input type="text" name="title" placeholder="タイトル" autocomplete="off">
        </p>
        <p class="err"><?= h($addbook->getErrors('title')); ?></p>
        <p>
          <input type="hidden" name="MAX_FILE_SIZE" value="<?= h(MAX_FILE_SIZE); ?>">
          <input class="image" type="file" name="book-image" accept="image/*" capture="camera">
        </p>
        <p class="err"><?= h($addbook->getErrors('book-image')); ?></p>
        <p>
          <input type="text" name="reason" placeholder="おすすめの理由" autocomplete="off">
        </p>
        <p class="err"><?= h($addbook->getErrors('reason')); ?></p>
        <p>
          <input class="login button" type="submit" value="アップ">
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