<?php


namespace App;



class FileEmployeeRepository implements EmployeeRepository
{
    private $fileName;

    /**
     * EmployeeRepository constructor.
     */
    public function __construct($fileName = null)
    {
        $this->fileName = $fileName;
    }

    public function getEmployees($fileName): array
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