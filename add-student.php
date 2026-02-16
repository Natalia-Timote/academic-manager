<?php

require_once 'vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;

$databasePath = __DIR__ . '/database.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$student = new Student(null, 'Amélia', new DateTimeImmutable('1997-02-26'));

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date)";
$statement = $pdo->prepare($sqlInsert);
$statement->bindValue('name', $student->name());
$statement->bindValue('birth_date', $student->birthDate()->format('Y-m-d'));

if($statement->execute()) {
    echo 'Aluno incluído';
};