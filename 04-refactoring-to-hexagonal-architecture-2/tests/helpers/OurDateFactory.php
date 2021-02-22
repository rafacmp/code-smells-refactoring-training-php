<?php


namespace helpers;


use App\core\OurDate;
use App\infrastructure\repositories\DateRepresentation;

class OurDateFactory
{
    public static function ourDateFromString(string $dateAsString): OurDate
    {
        return (new DateRepresentation($dateAsString))->toDate();
    }

}