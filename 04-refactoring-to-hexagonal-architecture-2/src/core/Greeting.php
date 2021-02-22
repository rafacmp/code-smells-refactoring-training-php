<?php


namespace App\core;


class Greeting
{
    private string $header;
    private string $content;

    public function __construct(string $header, string $content)
    {
        $this->header = $header;
        $this->content = $content;
    }

    public static function forBirthdayOf(Employee $employee)
    {
        $content = "Happy Birthday, dear $employee->firstName!";
        $header = "Happy Birthday!";
        return new Greeting($header, $content);
    }

    public function header(): string
    {
        return $this->header;
    }

    public function content(): string
    {
        return $this->content;
    }

}