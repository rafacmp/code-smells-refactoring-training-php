<?php

declare(strict_types=1);

namespace App;

use DateTime;

class Employee
{
    private OurDate $birthDate;
    private string $lastName;
    private string $firstName;
    private string $email;

    public function __construct(string $firstName, string $lastName, string $email, OurDate $birthDate)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->email = $email;
    }

    public function isBirthday(OurDate $today)
    {
        return $today->isSameDay($this->birthDate);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

}
