<?php

declare(strict_types=1);

use helpers\OurDateFactory;
use PHPUnit\Framework\TestCase;

class OurDateTest extends TestCase
{

    public function test_identifies_if_two_dates_were_in_the_same_day()
    {
        $OurDate = OurDateFactory::ourDateFromString('1789/01/24');
        $sameDay = OurDateFactory::ourDateFromString('2001/01/24');
        $notSameDay = OurDateFactory::ourDateFromString('1789/01/25');
        $notSameMonth = OurDateFactory::ourDateFromString('1789/02/25');

        $this->assertTrue($OurDate->isSameDay($sameDay), 'same');
        $this->assertFalse($OurDate->isSameDay($notSameDay), 'not same day');
        $this->assertFalse($OurDate->isSameDay($notSameMonth), 'not same month');
    }

}
