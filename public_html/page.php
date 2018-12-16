<?php

require_once(__DIR__ . '/../config/config.php');

// var_dump($_SESSION['me']);
$app = new MyApp\Controller\Index();
$app->run();
$addbook = new MyApp\Controller\Addbook();
$addbook->run();


//$app->me()
//$addbook->getValues()->books
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>トップページ</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shitajicss@5.0.0/docs/css/shitaji.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
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
    <a class="add" href="/addbook.php"><i class="fas fa-fw fa-plus"></i>本を追加</a>
    <div class="container page">
        <h2 class="book-title title"><?= h($addbook->title); ?></h2>
        <div>
          <div class="img-wrapper"><img src="<?= h($addbook->image); ?>" alt="<?= h($addbook->title); ?>"></div>
          <div class="text-wrapper"><p><?= h($addbook->reason); ?></p></div>
        </div>
        <p>
          <a class="link" href="/edit.php">編集</a>
          <a class="link" href="/delete.php">削除</a>
          <a class="link" href="/">戻る</a>
        </p>
    </div>
  </main>
  <footer></footer>
</body>
</html>