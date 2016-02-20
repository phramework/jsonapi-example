<?php

require __DIR__ . '/../vendor/autoload.php';

//Include settings
$settings = include __DIR__ . '/../settings.php';

unlink($settings['db']->file);

$adapter = new \Phramework\Database\SQLite($settings['db']);

$adapter->execute(
    'CREATE TABLE article(
        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        `title` varchar(255),
        `body` TEXT,
        `creator-user_id` int,
        `status` int
    )'
);

$adapter->execute(
    'CREATE TABLE `tag`(
        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        `title` varchar(255),
        `status` int
    )'
);

$adapter->execute(
    'CREATE TABLE `article-tag`(
        `article_id` INTEGER,
        `tag_id` INTEGER,
        `status` int
    )'
);

$adapter->execute(
    'CREATE TABLE `user`(
        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        `username` varchar(255),
        `name` varchar(255),
        `status` int
    )'
);

$articles = [
    [1, 'Hello World', 'HELLO WORLD', 1, 1],
    [2, 'About us', 'We are...', 1, 1]
];

$tags = [
    [1, 'blog', 1],
    [2, 'programming', 1],
    [3, 'php', 1],
    [4, 'html', 0]
];

$articles_tags = [
    [1, 1, 1],
    [1, 2, 1],
    [2, 1, 1]
];

$users = [
    [1, 'nohponex', 'Xenofon Spafaridis', 1],
    [2, 'janedoe', 'Jane Doe', 0]
];


foreach ($users as $user) {
    $adapter->execute(
        'INSERT INTO `user` (`id`, `username`, `name`, `status`)
      VALUES (?, ?, ?, ?)',
        $user
    );
}

foreach ($articles as $article) {
    $adapter->execute(
        'INSERT INTO `article` (`id`, `title`, `body`, `creator-user_id`, `status`)
      VALUES (?, ?, ?, ?, ?)',
        $article
    );
}

foreach ($tags as $tag) {
    $adapter->execute(
        'INSERT INTO `tag` (`id`, `title`, `status`)
          VALUES (?, ?, ?)',
        $tag
    );
}

foreach ($articles_tags as $article_tag) {
    $adapter->execute(
        'INSERT INTO `article-tag` (`article_id`, `tag_id`, `status`)
      VALUES (?, ?, ?)',
        $article_tag
    );
}

/*
$adapter->exec(
    'CREATE TABLE `article-tag`(`article_id` int, `tag_id` int,  `status` int)');
$adapter->exec(
    'INSERT INTO `article-tag` (`article_id`, `tag_id`, `status`)
          VALUES (1, 1, 1)');
$adapter->exec(
    'INSERT INTO `article-tag` (`article_id`, `tag_id`, `status`)
          VALUES (1, 2, 1)');

$adapter->exec(
    'INSERT INTO `article-tag` (`article_id`, `tag_id`, `status`)
          VALUES (2, 1, 1)');

$adapter->exec(
    'CREATE TABLE `tag`(`id` int, `title` varchar(255), `status` int)');
$adapter->exec(
    'INSERT INTO `tag` (`id`, `title`, `status`)
          VALUES (1, "blog", 1)');
$adapter->exec(
    'INSERT INTO `tag` (`id`, `title`, `status`)
          VALUES (2, "programming", 1)');

$adapter->exec('INSERT INTO `tag` (`id`, `title`, `status`)
          VALUES (3, "php", 1)');
$adapter->exec('INSERT INTO `tag` (`id`, `title`, `status`)
          VALUES (0, "html", 0)');

$adapter->exec('CREATE TABLE `user`(`id` int, `username` varchar(255), `name` varchar(255), `status` int)');
$adapter->exec('INSERT INTO user (`id`, `username`, `name`, `status`)
          VALUES (1, "nohponex", "Xenofon Spafaridis", 1)');

$adapter->exec('INSERT INTO user (`id`, `username`, `name`, `status`)
          VALUES (2, "xenofons", "Xenofon Spafaridis", 0)');

$adapter->exec('CREATE TABLE article(`id` int, `title` varchar(255), `body` TEXT, `creator-user_id` int, `status` int)');

$adapter->exec('INSERT INTO article (`id`, `title`, `body`, `creator-user_id`, `status`)
          VALUES (1, "hello World", "HELLO WORLD", 1, 1)');
$adapter->exec('INSERT INTO article (`id`, `title`, `body`, `creator-user_id`, `status`)
          VALUES (2, "Blog post", "BLOG POST", 1, 1)')*/