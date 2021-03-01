<?php


namespace App\core;


class GreetingMessage
{
    private string $to;
    private Greeting $greeting;

    private function __construct(string $to, Greeting $greeting)
    {
        $this->to = $to;
        $this->greeting = $greeting;
    }

    public static function generateForSome(array $employees): array
    {
        return array_map(
            function ($employee) {
                $greeting = Greeting::forBirthdayOf($employee);
                $recipient = $employee->getEmail();
                return new GreetingMessage($recipient, $greeting);
            },
            $employees
        );
    }

    public function getSubject(): string
    {
        return $this->greeting->getHeader();
    }

    public function getText(): string
    {
        return $this->greeting->getContent();
    }

    public function getTo(): string
    {
        return $this->to;
    }

}