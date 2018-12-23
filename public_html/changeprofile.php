<?php

require_once(__DIR__ . '/../config/config.php');

// var_dump($_SESSION['me']);
$app = new MyApp\Controller\Profile();
// $app->run();
$changepro = new MyApp\Controller\Changeprofile();
$changepro->run();
// var_dump($changepro->getErrors());
// exit;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>プロフィール変更</title>
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
    <div class="container login">
      <h1 class="title">プロフィール変更</h1>
      <form action="" method="post" enctype="multipart/form-data">
        <p>
          <label for="name">名前：</label>
          <input type="text" name="name" id="name" value="<?= h($app->me()->name); ?>" placeholder="名前" autocomplete="off">
        </p>
        <p class="err"><?= h($changepro->getErrors('name')); ?></p>
        <p>
          <input type="hidden" name="MAX_FILE_SIZE" value="<?= h(MAX_FILE_SIZE); ?>">
          <input class="profile_image" type="file" name="profile_image" accept="image/*" capture="camera">
        </p>
        <p class="err"><?= h($changepro->getErrors('profile_image')); ?></p>
        <p>
          <label for="email">メール：</label>
          <input type="email" name="email" id="email" placeholder="メールアドレス" value="<?= h($app->me()->email); ?>" autocomplete="off">
        </p>
        <p>
          <label for="password">パスワード：</label>
          <input type="password" name="password" id="password" placeholder="パスワード">
        </p>
        <p class="err"><?= h($changepro->getErrors('password')); ?></p>
        <p>
          <input class="login button" type="submit" value="変更">
        </p>
        <p class="err"><?= h($changepro->getErrors('login')); ?></p>
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