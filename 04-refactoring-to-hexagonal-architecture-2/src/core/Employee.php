<?php

declare(strict_types=1);


namespace App\core;


class Employee
{
    private OurDate $birthDate;
    private string $lastName;
    public string $firstName;
    private string $email;

    public function __construct(string $firstName, string $lastName, OurDate $birthDate, string $email)
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

    public function email(): string
    {
        return $this->email;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function equals($employee): bool
    {
        if ($this == $employee) {
            return true;
        }

        if (null === $employee) {
            return false;
        }

        if (!($employee instanceof self)) {
            return false;
        }

        if (null === $this->birthDate) {
            if (null !== $employee->birthDate) {
                return false;
            }
        } elseif (!$this->birthDate->equals($employee->birthDate)) {
            return false;
        }

        if (null === $this->email) {
            if (null !== $employee->email) {
                return false;
            }
        } elseif ($this->email !== $employee->email) {
            return false;
        }

        if (null === $this->firstName) {
            if (null !== $employee->firstName) {
                return false;
            }
        } elseif ($this->firstName !== $employee->firstName) {
            return false;
        }

        if (null === $this->lastName) {
            if (null !== $employee->lastName) {
                return false;
            }
        } elseif (!$this->lastName !== $employee->lastName) {
            return false;
        }

        return true;
    }
}
