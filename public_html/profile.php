<?php

require_once(__DIR__ . '/../config/config.php');

// var_dump($_SESSION['me']);
$app = new MyApp\Controller\Profile();

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
  <main class="profile">
    <section class="container profile">
      <h1 class="title">プロフィール</h1>
      <div>
        <div class="img-wrapper">
          <img src="<?= h($app->me()->profile_image); ?>" alt="プロフィール画像">
        </div>
        <ul>
          <li><span>名前: </span><?= h($app->me()->name); ?></li>
          <li><span>メールアドレス: </span><?= h($app->me()->email); ?></li>
        </ul>
      </div>
      <div>
        <ul>
          <li><a class="button" href="changeprofile.php?id=<?= h($app->me()->id); ?>">変更</a></li>
          <li><a class="link" href="/">戻る</a></li>
        </ul>
      </div>
    </section>
  </main>
  <footer></footer>
</body>
</html>