<?php


namespace App;


class FileEmployeeRepository
{

    /**
     * EmployeeRepository constructor.
     */
    public function __construct()
    {
    }

    public function getEmployees($fileName) {
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