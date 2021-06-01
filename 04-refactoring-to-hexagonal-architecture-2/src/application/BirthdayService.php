<?php

declare(strict_types=1);

namespace App\application;

use App\core\EmployeeRepository;
use App\core\GreetingMessage;
use App\core\GreetingsSender;
use App\core\OurDate;

class BirthdayService
{
    private EmployeeRepository $employeeRepository;
    private GreetingsSender $greetingsSender;

    public function __construct(EmployeeRepository $employeeRepository, GreetingsSender $greetingsSender)
    {
        $this->employeeRepository = $employeeRepository;
        $this->greetingsSender = $greetingsSender;
    }

    public function sendGreetings(
        OurDate $date
    ): void {

        $this->greetingsSender->send($this->greetingMessagesFor($this->employeesHavingBirthday($date)));
    }

    private function greetingMessagesFor(array $employees): array
    {
        return GreetingMessage::generateForSome($employees);
    }

    private function employeesHavingBirthday($today): array
    {
        return $this->employeeRepository->employeesWhoseBirthdayIs($today);
    }

}
