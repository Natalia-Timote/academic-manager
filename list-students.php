<?php

require_once 'vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;

$databasePath = __DIR__ . '/database.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$statement = $pdo->query('SELECT * FROM students WHERE id = 1;');

while ($studentData = $statement->fetch(PDO::FETCH_ASSOC)) {
    $student = new Student(
        $studentData['id'], 
        $studentData['name'], 
        new DateTimeImmutable($studentData['birth_date'])
    );

    echo $student->age() . PHP_EOL;
};
exit();

var_dump($studentDataList);

foreach ($studentDataList as $studentData) {
    $studentList[] = new Student(
        $studentData['id'], 
        $studentData['name'], 
        new DateTimeImmutable($studentData['birth_date'])
    );
};

var_dump($studentList);