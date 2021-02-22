<?php


namespace App\core;


interface EmployeeRepository
{
    function whoseBirthdayIs(OurDate $today): array;
}