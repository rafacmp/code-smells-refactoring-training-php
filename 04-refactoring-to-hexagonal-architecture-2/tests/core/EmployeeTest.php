<?php

declare(strict_types=1);

use App\core\Employee;
use App\core\OurDate;
use helpers\OurDateFactory;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    public function testBirthday(){
        $employee = new Employee("foo", "bar", OurDateFactory::ourDateFromString("1990/01/31"), "a@b.c");

        $this->assertFalse($employee->isBirthday(OurDateFactory::ourDateFromString("2008/01/30")), "no birthday");
        $this->assertTrue($employee->isBirthday(OurDateFactory::ourDateFromString("2008/01/31")), "birthday");
    }
}