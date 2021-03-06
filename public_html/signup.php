<?php

//新規会員登録
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Signup();

$app->run();
// var_dump($app->getValues()->email);
// exit;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>サインアップ</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shitajicss@5.0.0/docs/css/shitaji.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1 class="title"><a href="/">Shoseki Uploader</a></h1>
  </header>
  <main>
    <div class="container signup">
      <h1 class="title">サインアップ</h1>
      <form action="" method="post" enctype="multipart/form-data">
        <p>
          <input type="text" name="name" value="<?= isset($app->getValues()->name) ? h($app->getValues()->name) : ''; ?>" placeholder="名前" autocomplete="off">
        </p>
        <p class="err"><?= h($app->getErrors('name')); ?></p>
        <p>
          <input type="hidden" name="MAX_FILE_SIZE" value="<?= h(MAX_FILE_SIZE); ?>">
          <input class="profile-image" type="file" name="profile-image" accept="image/*" capture="camera">
        </p>
        <p class="err"><?= h($app->getErrors('profile-image')); ?></p>
        <p>
          <input type="email" name="email" placeholder="メールアドレス" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>" autocomplete="off">
        </p>
        <p class="err"><?= h($app->getErrors('email')); ?></p>
        <p>
          <input type="password" name="password" placeholder="パスワード">
        </p>
        <p class="err"><?= h($app->getErrors('password')); ?></p>
        <p>
          <input class="login button" type="submit" value="サインアップ">
        </p>
        <p>
          <a class="link" href="/login.php">ログイン</a>
        </p>
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      </form>
    </div>
  </main>
  <footer></footer>
</body>
</html>