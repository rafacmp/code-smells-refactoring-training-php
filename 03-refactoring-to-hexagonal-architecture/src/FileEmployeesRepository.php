<?php


namespace App;


class FileEmployeesRepository implements EmployeesRepository
{

    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function getEmployees(): array
    {
        $fileHandler = fopen($this->fileName, 'rb');
        fgetcsv($fileHandler);

        $employees = [];
        while ($employeeData = fgetcsv($fileHandler, null)) {
            $employeeData = array_map('trim', $employeeData);
            $employee = new Employee($employeeData[1], $employeeData[0], $employeeData[2], $employeeData[3]);
            $employees[] = $employee;

        }
        return $employees;
    }
}