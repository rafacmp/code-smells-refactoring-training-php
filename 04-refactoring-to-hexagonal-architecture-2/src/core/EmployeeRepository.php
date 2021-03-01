<?php


namespace App\core;


interface EmployeeRepository
{
    function employeesWhoseBirthdayIs(OurDate $date): array;
}