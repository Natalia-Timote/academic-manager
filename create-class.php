<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

$connection->beginTransaction();

$aStudent = new Student(
    id: null,
    name: 'Alfredo Fredo',
    birthDate: new DateTimeImmutable('2002-04-23')
);

$studentRepository->save($aStudent);

$anotherStudent = new Student(
    id: null,
    name:'Amélia Mélia',
    birthDate: new DateTimeImmutable('2002-06-12')
);

$studentRepository->save($anotherStudent);

$connection->rollBack();