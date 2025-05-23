<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News and Updates - CVSU Silang</title>
    <link rel="stylesheet" href="../../../assets/css/public_home.css">
    <link rel="stylesheet" href="../../../assets/css/public_news_list.css">

    <style>
        .pagination p {
            color: white;
        }

        .home-news-list {
            margin-top: 1rem;
            margin-inline: 7.5%;
        }
    </style>
</head>

<body class="public-body">
    <main class="public-main">
        <header class="public-header">
            <h2>NEWS AND UPDATES</h2>
            <h4><i>HOME >> NEWS AND UPDATES</i></h4>
            <hr>
        </header>

        <?php
        $controller->renderNewsList();
        ?>
    </main>
</body>

</html>