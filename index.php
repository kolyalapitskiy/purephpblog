<?php

$config = require('config.php');
require('core/database.php');


$db = new Database($config['database']);

$blogs = $db -> query();
//var_dump($blogs['id'] === '1');
//var_dump($blogs['id' == 1]);



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>BLOG TITLE</h1>
    <p>This article summarize what the blog is about</p>
    <?php foreach ($blogs as $blog) : ?>
        <h2>This is fucking TITLE:    <?= $blog['title'] ?></h2>
        <h2>THIS IS FUCKING BLOG BODY:   <?= $blog['blog_body'] ?></h2>
        <h2>This is a time when the post was created:   <?= $blog['created_at'] ?></h2>
        <h2> Вова пишет:<?= $blog['comment_body'] ?></h2>
        <h2>This is the commentaries for the post:
            <?php foreach ($blog['comments'] as $comment) : ?>
                <h2> Вова пишет: <?= $comment['comment_body'] ?></h2>
            <?php endforeach; ?>
        </h2>
        <hr/>
    <?php endforeach; ?>
</body>
</html>








