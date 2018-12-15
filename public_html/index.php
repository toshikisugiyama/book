<?php

require_once(__DIR__ . '/../config/config.php');

// var_dump($_SESSION['me']);
$app = new MyApp\Controller\Index();
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
    <form class="logout" action="logout.php" method="post" id="logout">
      <?= h($app->me()->name); ?> <input class="button" type="submit" value="Log Out">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
  </header>
  <main>
    <div class="container index">
      <section class="book-box">
        <h2 class="book-title title"><a href="">タイトル</a></h2>
        <div class="img-wrapper"><a href=""><img src="" alt="タイトル"></a></div>
        <div class="text-wrapper"><p>オススメの理由</p></div>
      </section>
    </div>
  </main>
  <footer></footer>
</body>
</html>