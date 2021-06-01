<?php

declare(strict_types=1);

namespace App;

use DateTime;

class OurDate
{
    private DateTime $date;

    public function __construct($date = null)
    {
        if (!$date instanceof DateTime) {
            throw new \InvalidArgumentException('ParseException');
        }
        $this->date = $date;
    }

    public function isSameDay($anotherDate): bool
    {
        return
            $anotherDate->getDay() === $this->getDay()
            && $anotherDate->getMonth() === $this->getMonth();
    }

    private function getDay(): int
    {
        return (int)$this->date->format('d');
    }

    private function getMonth(): int
    {
        return (int)$this->date->format('m');
    }

}
