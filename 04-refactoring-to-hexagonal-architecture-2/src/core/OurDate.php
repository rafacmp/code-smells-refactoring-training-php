<?php

declare(strict_types=1);


namespace App\core;


use DateTime;

class OurDate
{

    private DateTime $date;

    public function __construct(DateTime $date)
    {
        $this->date = $date;
    }

    public function isSameDay(OurDate $anotherDate): bool
    {
        return
            $anotherDate->getDay() === $this->getDay()
            && $anotherDate->getMonth() === $this->getMonth();
    }

    public function equals($ourDate): bool
    {
        if (!($ourDate instanceof OurDate)) {
            return false;
        }

        return $ourDate->date->getTimestamp() === $this->date->getTimestamp();
    }

    public function getDay(): int
    {
        return (int)$this->date->format('d');
    }

    public function getMonth(): int
    {
        return (int)$this->date->format('m');
    }
}