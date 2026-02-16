<?php

require_once 'vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

$pdo = ConnectionCreator::createConnection();

$student = new Student(null, 'Amélia', new DateTimeImmutable('1997-02-26'));

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date)";
$statement = $pdo->prepare($sqlInsert);
$statement->bindValue('name', $student->name());
$statement->bindValue('birth_date', $student->birthDate()->format('Y-m-d'));

if($statement->execute()) {
    echo 'Aluno incluído';
};