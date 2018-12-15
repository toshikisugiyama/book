<?php

//新規会員登録
require_once(__DIR__ . '/../config/config.php');

$app = new MyApp\Controller\Signup();

$app->run();
// var_dump($_POST);
// exit;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Sign Up</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shitajicss@5.0.0/docs/css/shitaji.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header></header>
  <main>
    <div class="container signup">
      <h1 class="title">Sign Up</h1>
      <form action="" method="post">
        <p>
          <input type="text" name="name" value="<?= isset($app->getValues()->name) ? h($app->getValues()->name) : ''; ?>" placeholder="Name" autocomplete="off">
        </p>
        <p>
          <input type="email" name="email" placeholder="E-mail" value="<?= isset($app->getValues()->email) ? h($app->getValues()->email) : ''; ?>" autocomplete="off">
        </p>
        <p class="err"><?= h($app->getErrors('email')); ?></p>
        <p>
          <input type="password" name="password" placeholder="Password">
        </p>
        <p class="err"><?= h($app->getErrors('password')); ?></p>
        <p>
          <input class="login button" type="submit" value="Sign Up">
        </p>
        <p>
          <a class="link" href="/login.php">Log In</a>
        </p>
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      </form>
    </div>
  </main>
  <footer></footer>
</body>
</html>