<?php

declare(strict_types=1);


namespace App\core;


class Employee
{
    private OurDate $birthDate;
    private string $lastName;
    private string $firstName;
    private string $email;

    public function __construct(string $firstName, string $lastName, OurDate $birthDate, string $email)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->email = $email;
    }

    public function isBirthday(OurDate $today) : bool
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
