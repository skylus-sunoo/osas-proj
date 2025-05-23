<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $controller->getNewsTitle($_POST['news_ID']);?></title>
    <link rel="stylesheet" href="../../../assets/css/public_home.css">
    <link rel="stylesheet" href="../../../assets/css/public_news.css">
</head>

<body class="public-body font-NotoSans">
    <main class="public-main home-main">
        <div class="home-admissions">
            <?php
            $controller->showNews($_POST['news_ID']);
            ?>
        </div>

        <aside class="home-news">
            <h2>LATEST NEWS</h2>

            <?php
            $controller->showLatestNews();
            ?>
        </aside>
    </main>
</body>

</html>