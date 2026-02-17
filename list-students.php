<?php

require_once 'vendor/autoload.php';

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

$pdo = ConnectionCreator::createConnection();

$repository = new PdoStudentRepository($pdo);
$studentList = $repository->allStudents();

var_dump($studentList);