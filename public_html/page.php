<?php

require_once(__DIR__ . '/../config/config.php');

// var_dump($_SESSION['me']);
$app = new MyApp\Controller\Index();
$app->run();
$addbook = new MyApp\Controller\Addbook();
$addbook->run();
$page = new MyApp\Controller\Page();


//$app->me()
//$addbook->getValues()->books
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>詳細表示</title>
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
  <main class="page">
    <a class="add" href="/addbook.php"><i class="fas fa-fw fa-plus"></i>本を追加</a>
    <section class="container page">
      <h2 class="book-title title"><?= h($page->show()['title']); ?></h2>
      <div>
        <div class="img-wrapper"><img src="<?= h($page->show()['image']); ?>" alt="<?= h($_GET['title']); ?>"></div>
        <div class="text-wrapper"><p><?= h($page->show()['reason']); ?></p></div>
      </div>
      <div class="contributor">
        <div><img src="<?= h($page->show()['profile_image']); ?>" alt="投稿者"></div>
        <span><?= h($page->show()['name']); ?></span>
      </div>
    </section>
    <div class="page button-wrapper">
      <ul>
        <li><a class="link button" href="/edit.php?id=<?= h($_GET['id']); ?>">編集</a></li>
        <li> <a class="link button" href="/delete.php?id=<?= h($_GET['id']); ?>">削除</a></li>
        <li><a class="link" href="/">戻る</a></li>
      </ul>
    </div>
  </main>
  <footer></footer>
</body>
</html>