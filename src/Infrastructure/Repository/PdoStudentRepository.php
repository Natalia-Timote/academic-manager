<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Phone;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use DateTimeImmutable;
use PDO;
use RuntimeException;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allStudents(): array
    {
        $statement = $this->connection->query('SELECT * FROM students;');

        return $this->hydrateStudentList($statement);
    }

    public function studentsBirthAt($birthDate): array
    {
        $statement = $this->connection->prepare('SELECT * FROM students WHERE birth_date = :birth_date;');
        $statement->bindValue(':birth_date', $birthDate->format('Y-m-d'));
        $statement->execute();

        return $this->hydrateStudentList($statement);
    }

    private function hydrateStudentList($statement): array
    {
        $studentDataList = $statement->fetchAll();
        $studentList = [];

        foreach ($studentDataList as $studentData) {
            $studentList[] = $student = new Student(
                $studentData['id'],
                $studentData['name'],
                new DateTimeImmutable($studentData['birth_date'])
            );

            $this->fillPhoneOf($student);
        }
        return $studentList;
    }

    private function fillPhoneOf(Student $student): void
    {
        $statement = $this->connection->prepare('SELECT id, area_code, number FROM phones WHERE student_id = :id');
        $statement->bindValue(':id', $student->id(), PDO::PARAM_INT);
        $statement->execute();

        $phoneDataList = $statement->fetchAll();
        foreach ($phoneDataList as $phoneData) {
            $phone = new Phone(
                $phoneData['id'],
                $phoneData['area_code'],
                $phoneData['number']
            );

            $student->addPhone($phone);
        }
    }

    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }

        return $this->update($student);
    }

    private function insert(Student $student): bool
    {
        $statement = $this->connection->prepare('INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);');

        $success = $statement->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d')
        ]);

        if ($success) {
            $student->defineId($this->connection->lastInsertId());
        };

        return $success;
    }

    private function update(Student $student): bool
    {
        $statement = $this->connection->prepare('UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id');
        $statement->bindValue(':name', $student->name());
        $statement->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));
        $statement->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $statement->execute();
    }

    public function remove(Student $student): bool
    {
        $statement = $this->connection->prepare('DELETE FROM students WHERE id= :id');
        $statement->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $statement->execute();
    }
};
