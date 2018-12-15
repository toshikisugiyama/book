<?php

//ログイン
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Login();

$app->run();

// echo "login screen";
// exit;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Log In</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shitajicss@5.0.0/docs/css/shitaji.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header></header>
  <main>
    <div class="container login">
      <h1 class="title">Log In</h1>
      <form action="" method="post">
        <p>
          <input type="text" name="name" value="<?= isset($app->getValues()->name) ? h($app->getValues()->name) : ''; ?>" placeholder="Name" autocomplete="off">
        </p>
        <p>
          <input type="email" name="email" placeholder="E-mail" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>" autocomplete="off">
        </p>
        <p>
          <input type="password" name="password" placeholder="Password">
        </p>
        <p>
          <input class="login button" type="submit" value="Log In">
        </p>
        <p class="err"><?= h($app->getErrors('login')); ?></p>
        <p>
          <a class="link" href="/signup.php">Sign Up</a>
        </p>
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      </form>
    </div>
  </main>
  <footer></footer>
</body>
</html>