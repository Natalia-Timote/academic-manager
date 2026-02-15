<?php

$databasePath = __DIR__ . '/database.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

echo 'Connected';

$pdo->exec('CREATE TABLE students (id INTEGER PRIMARY KEY, name TEXT, birdth_date TEXT);');