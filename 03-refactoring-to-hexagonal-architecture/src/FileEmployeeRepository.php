<?php

namespace App;

use DateTime;

class FileEmployeeRepository implements EmployeeRepository
{
    private $fileName;

    public function __construct($fileName = null)
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
            $birthday = new OurDate(DateTime::createFromFormat('Y/m/d H:i:s', $employeeData[2] . ' 00:00:00'));
            $employee = new Employee($employeeData[1], $employeeData[0], $employeeData[3], $birthday);

            $employees[] = $employee;
        }

        return $employees;
    }
}
