<?php

declare(strict_types=1);

use App\OurDate;
use PHPUnit\Framework\TestCase;

class OurDateTest extends TestCase
{

    public function testIsSameDate()
    {
        $OurDate = new OurDate(DateTime::createFromFormat('Y/m/d H:i:s', '1789/01/24' . ' 00:00:00'));
        $sameDay = new OurDate(DateTime::createFromFormat('Y/m/d H:i:s', '2001/01/24' . ' 00:00:00'));
        $notSameDay = new OurDate(DateTime::createFromFormat('Y/m/d H:i:s', '1789/01/25' . ' 00:00:00'));
        $notSameMonth = new OurDate(DateTime::createFromFormat('Y/m/d H:i:s', '1789/02/25' . ' 00:00:00'));

        $this->assertTrue($OurDate->isSameDay($sameDay), 'same');
        $this->assertFalse($OurDate->isSameDay($notSameDay), 'not same day');
        $this->assertFalse($OurDate->isSameDay($notSameMonth), 'not same month');
    }

    public function testExceptionInCreationObject()
    {
        $this->expectException(InvalidArgumentException::class);
        $invalidDate = new OurDate(DateTime::createFromFormat('Y/m/d H:i:s', "" . ' 00:00:00'));
        $anotherInvalidDate = new OurDate();
    }
}
