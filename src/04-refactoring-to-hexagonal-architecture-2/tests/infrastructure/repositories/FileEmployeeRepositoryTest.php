<?php

declare(strict_types=1);

use App\core\CannotReadEmployeesException;
use App\core\OurDate;
use App\infrastructure\repositories\FileEmployeesRepository;
use helpers\OurDateFactory;
use PHPUnit\Framework\TestCase;

class FileEmployeeRepositoryTest extends TestCase
{
    private OurDate $ANY_DATE;

    protected function setUp(): void
    {
        $this->ANY_DATE = OurDateFactory::ourDateFromString("2016/01/01");
    }

    public function test_fails_when_the_file_does_not_exist(): void
    {
        $employeeRepository = new FileEmployeesRepository("non-existing.file");
        $this->expectException(CannotReadEmployeesException::class);
        $this->expectExceptionMessageMatches("/cannot loadFrom file/");
        $this->expectExceptionMessageMatches("/non-existing.file/");

        $employeeRepository->employeesWhoseBirthdayIs($this->ANY_DATE);
    }

    public function test_fails_when_the_file_does_not_have_the_necessary_fields(): void
    {
        $path = dirname(__FILE__) . "/../../resources/wrong_data__wrong-date-format.csv";
        $employeeRepository = new FileEmployeesRepository($path);
        $this->expectException(CannotReadEmployeesException::class);
        $this->expectExceptionMessageMatches("/Badly formatted employee birth date in: '2016-01-01'/");

        $employeeRepository->employeesWhoseBirthdayIs($this->ANY_DATE);
    }
}
