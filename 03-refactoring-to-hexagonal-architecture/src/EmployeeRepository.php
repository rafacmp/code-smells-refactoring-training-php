<?php


namespace App;


interface EmployeeRepository
{

    function getEmployees($fileName): array;
}