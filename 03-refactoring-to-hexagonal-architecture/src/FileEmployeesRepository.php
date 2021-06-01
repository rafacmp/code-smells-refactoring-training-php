<?php


namespace App;


class FileEmployeesRepository
{

    public function getEmployees(string $fileName): array
    {
        $fileHandler = fopen($fileName, 'rb');
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