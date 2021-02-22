<?php


namespace App\infrastructure\repositories;


use App\core\CannotReadEmployeesException;
use App\core\Employee;
use App\core\EmployeeRepository;
use App\core\OurDate;

class FileEmployeesRepository implements EmployeeRepository
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    function whoseBirthdayIs(OurDate $today): array
    {
        return array_filter($this->allEmployees(), function(Employee $employee) use ($today){
           return $employee->isBirthday($today);
        });
    }

    private function allEmployees()
    {
        $employees = [];
        $fileHandler = $this->openFile();
        fgetcsv($fileHandler);
        while ($employeeData = fgetcsv($fileHandler, null)) {
            $employeeData = array_map('trim', $employeeData);
            $employees []= new Employee(
                $employeeData[1],
                $employeeData[0],
                $this->getExtractDate($employeeData),
                $employeeData[3]);
        }
       return $employees;
    }

    private function openFile()
    {
        try {
            $fileHandler = fopen($this->path, 'r');
        } catch (\Exception $e) {
            throw new CannotReadEmployeesException("cannot loadFrom file = '$this->path'");
        }
        return $fileHandler;
    }

    /**
     * @param $employeeData
     * @return mixed
     */
    private function getExtractDate($employeeData)
    {
        $dateAsString = $employeeData[2];
        try {
            return (new DateRepresentation($dateAsString))->toDate();
        } catch (\Exception $e) {
            throw new CannotReadEmployeesException("Badly formatted employee birth date in: '$dateAsString'");
        }
    }


}