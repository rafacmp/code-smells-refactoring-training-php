<?php

namespace App;

interface EmployeesRepository
{
    public function getEmployees(): array;
}