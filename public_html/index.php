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
    <h1 class="title">おすすめ書籍一覧</h1>
    <div class="container index">
      <?php if ($addbook->getValues()->books): ?>
        <?php foreach ($addbook->getValues()->books as $books => $book) : ?>
          <section class="book-box">
            <h2 class="book-title title"><a href="/page.php"><?= h($book->title) ? h($book->title) : 'タイトルがありません'; ?></a></h2>
            <div class="img-wrapper"><a href="/page.php"><img src="<?= h($book->image); ?>" alt="<?= h($book->title) ? h($book->title) : 'タイトルがありません'; ?>"></a></div>
            <div class="text-wrapper"><p><?= h($book->reason) ? h($book->reason) : '理由がありません'; ?></p></div>
          </section>
        <?php endforeach; ?>
      <?php else: ?>
        <h2 class="book-title title">書籍はありません</h2>
      <?php endif ?>
    </div>
  </main>
  <footer></footer>
</body>
</html>