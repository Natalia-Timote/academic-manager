<?php

require_once 'vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;

$databasePath = __DIR__ . '/database.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$student = new Student(null, 'Lucas Rocha', new DateTimeImmutable('1997-02-26'));

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (?, ?)";
$statement = $pdo->prepare($sqlInsert);
$statement->bindValue(1, $student->name());
$statement->bindValue(2, $student->birthDate()->format('Y-m-d'));

if($statement->execute()) {
    echo 'Aluno incluído';
};