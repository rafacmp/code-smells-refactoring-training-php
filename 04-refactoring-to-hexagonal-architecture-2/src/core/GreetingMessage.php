<?php


namespace App\core;


class GreetingMessage
{
    private string $to;
    private Greeting $greeting;

    public function __construct(string $to, Greeting $greeting)
    {
        $this->to = $to;
        $this->greeting = $greeting;
    }

    public static function generateForSome(array $employees): array
    {
        return array_map('self::generateFor', $employees);
    }

    public static function generateFor(Employee $employee): GreetingMessage
    {
       $greeting = Greeting::forBirthdayOf($employee);
       $recipient = $employee->email();
       return new GreetingMessage($recipient, $greeting);
    }

    public function subject(): string
    {
        return $this->greeting->header();
    }

    public function text(): string
    {
        return $this->greeting->content();
    }

    public function to(): string
    {
        return $this->to;
    }

}