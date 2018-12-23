<?php

require_once(__DIR__ . '/../config/config.php');

// var_dump($_SESSION['me']);
$app = new MyApp\Controller\Index();
$app->run();
$addbook = new MyApp\Controller\Addbook();
$addbook->run();
// var_dump($app->me());
// var_dump($addbook->getValues()->books);
// exit;

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
      <a href="/profile.php"><img src="<?= h($app->me()->profile_image); ?>" alt="プロフィール画像"><span><?= h($app->me()->name); ?></span></a>
      <input class="button" type="submit" value="ログアウト">
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
  </header>
  <main>
    <a class="add" href="/addbook.php"><i class="fas fa-fw fa-plus"></i>本を追加</a>
    <h1 class="title">おすすめ書籍一覧</h1>
    <div class="container index">
      <?php if ($addbook->getValues()->books): ?>
        <?php foreach ($addbook->getValues()->books as $books => $book) : ?>
          <section class="book-box">
            <h2 class="book-title title"><?= h($book['title']) ? h($book['title']) : 'タイトルがありません'; ?></h2>
            <div class="img-wrapper"><img src="<?= h($book['image']); ?>" alt="<?= h($book['title']) ? h($book['title']) : 'タイトルがありません'; ?>"></div>
            <div class="text-wrapper"><p><?= h($book['reason']) ? h($book['reason']) : '理由がありません'; ?></p></div>
            <div class="contributor">
              <div><img src="<?= h($book['profile_image']); ?>" alt="投稿者"></div>
              <span><?= h($book['name']); ?></span>
            </div>
            <a href="/page.php?id=<?= h($book['id']) ?>"></a>
          </section>
        <?php endforeach; ?>
      <?php else: ?>
        <h2 class="book-title title">書籍はありません</h2>
      <?php endif ?>
    </div>
    <span id="to-top" class="to-top"></span>
  </main>
  <footer></footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
    'use strict';
    (function(){
      $('#to-top').on('click', function(){
        // alert('clicked!');
        $('html, body').animate({
          scrollTop:0
        },500);
      });
    })();
  </script>
</body>
</html>