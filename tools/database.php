<?php
declare(strict_types=1);
use Phramework\Examples\JSONAPI\Models\Administrator\User;

require __DIR__ . '/../vendor/autoload.php';

/*
 * This initialize the SQLite database schema and records
 * It's using hard-coded commands and lists of records to generate the database
 */

//Include settings
$settings = include __DIR__ . '/../settings.php';

//Delete SQLite database file if exists
if (file_exists($settings['db']->file)) {
    unlink($settings['db']->file);
}

/*
 * Initialize a SQLite database adapter
 */
$adapter = new \Phramework\Database\SQLite($settings['db']);

/*
 * Create schema
 */
$adapter->execute(
    'CREATE TABLE article(
        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        `title` VARCHAR(255),
        `body` TEXT,
        `creator-user_id` INTEGER,
        `status` INTEGER
    )'
);

$adapter->execute(
    'CREATE TABLE `tag`(
        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        `title` VARCHAR(255),
        `status` INTEGER
    )'
);

$adapter->execute(
    'CREATE TABLE `article-tag`(
        `article_id` INTEGER,
        `tag_id` INTEGER,
        `status` INTEGER
    )'
);

$adapter->execute(
    'CREATE TABLE `user`(
        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        `username` VARCHAR(255) UNIQUE,
        `name` VARCHAR(255),
        `email` VARCHAR(255) UNIQUE,
        `status` INTEGER,
        `password` VARCHAR(60) NOT NULL
    )'
);

/*
 * Define lists of records to be inserted
 */

$users = [
    [
        1,
        'nohponex',
        'Xenofon Spafaridis',
        1,
        'nohponex+nohponex@gmail.com',
        User::getHash('1234')
    ],
    [
        2,
        'janedoe',
        'Jane Doe',
        1,
        'nohponex+janedoe@gmail.com',
        User::getHash('1234')
    ],
    [
        3,
        'stark',
        'Jane Stark',
        0,
        'nohponex+stark@gmail.com',
        User::getHash('1234')
    ]
];

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

$articlesTags = [
    [1, 1, 1],
    [1, 2, 1],
    [2, 1, 1]
];


/*
 * Insert user records
 */
foreach ($users as $user) {
    $adapter->execute(
        'INSERT INTO `user`
        (`id`, `username`, `name`, `status`, `email`, `password`)
        VALUES (?, ?, ?, ?, ?, ?)',
        $user
    );
}

/*
 * Insert article records
 */
foreach ($articles as $article) {
    $adapter->execute(
        'INSERT INTO `article`
        (`id`, `title`, `body`, `creator-user_id`, `status`)
        VALUES (?, ?, ?, ?, ?)',
        $article
    );
}

/*
 * Insert tag records
 */
foreach ($tags as $tag) {
    $adapter->execute(
        'INSERT INTO `tag`
         (`id`, `title`, `status`)
         VALUES (?, ?, ?)',
        $tag
    );
}

/*
 * Insert article-tag records
 */
foreach ($articlesTags as $articleTag) {
    $adapter->execute(
        'INSERT INTO `article-tag`
        (`article_id`, `tag_id`, `status`)
        VALUES (?, ?, ?)',
        $articleTag
    );
}

/*
 * Close connection
 */
$adapter->close();
