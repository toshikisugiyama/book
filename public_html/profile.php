<?php

require_once(__DIR__ . '/../config/config.php');

// var_dump($_SESSION['me']);
$app = new MyApp\Controller\Profile();
$app->run();

//$app->me()
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
      <a href="/profile.php"><?= h($app->me()->name); ?></a>
      <input class="button" type="submit" value="ログアウト">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
  </header>
  <main>
    <div class="container login">
      <h1 class="title">プロフィール変更</h1>
      <form action="" method="post">
        <p>
          <label for="name">名前：</label>
          <input type="text" name="name" id="name" value="<?= h($app->me()->name); ?>" placeholder="Name" autocomplete="off">
        </p>
        <p>
          <label for="email">メール：</label>
          <input type="email" name="email" id="email" placeholder="E-mail" value="<?= h($app->me()->email); ?>" autocomplete="off">
        </p>
        <p>
          <label for="password">パスワード：</label>
          <input type="password" name="password" id="password" value="<?= h($app->me()->password); ?>" placeholder="Password">
        </p>
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