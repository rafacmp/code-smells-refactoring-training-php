<?php

declare(strict_types=1);

use App\BirthdayService;
use App\Customer;
use App\Movie;
use App\OurDate;
use App\Rental;
use PHPUnit\Framework\TestCase;

class VideoStoreTest extends TestCase
{
    private Customer $customer;

    protected function setUp(): void
    {
        $this->customer = new Customer("Fred");
    }

    public function testSingleNewReleaseStatement(): void
    {
        $this->customer->addRental(new Rental(new Movie("The Cell", Movie::NEW_RELEASE), 3));

        $this->assertThat($this->customer->statement(),
                $this->equalTo("Rental Record for Fred\n\tThe Cell\t9.0\nYou owed 9.0\nYou earned 2 frequent renter points\n"));
    }

    public function testDualNewReleaseStatement(): void
    {
        $this->customer->addRental(new Rental(new Movie("The Cell", Movie::NEW_RELEASE), 3));
        $this->customer->addRental(new Rental(new Movie("The Tigger Movie", Movie::NEW_RELEASE), 3));

        $this->assertThat($this->customer->statement(),
            $this->equalTo("Rental Record for Fred\n\tThe Cell\t9.0\n\tThe Tigger Movie\t9.0\nYou owed 18.0\nYou earned 4 frequent renter points\n"));
    }

    public function testSingleChildrensStatement(): void
    {
        $this->customer->addRental(new Rental(new Movie("The Tigger Movie", Movie::CHILDREN), 3));

        $this->assertThat($this->customer->statement(),
            $this->equalTo("Rental Record for Fred\n\tThe Tigger Movie\t1.5\nYou owed 1.5\nYou earned 1 frequent renter points\n"));
    }

    public function testSingleChildrensStatementRentedMoreThanThreeDaysAgo(): void
    {
        $this->customer->addRental(new Rental(new Movie("The Tigger Movie", Movie::CHILDREN), 4));

        $this->assertThat($this->customer->statement(),
            $this->equalTo("Rental Record for Fred\n\tThe Tigger Movie\t3.0\nYou owed 3.0\nYou earned 1 frequent renter points\n"));
    }

    public function testMultipleRegularStatement(): void
    {
        $this->customer->addRental(new Rental(new Movie("Plan 9 from Outer Space", Movie::REGULAR), 1));
        $this->customer->addRental(new Rental(new Movie("8 1/2", Movie::REGULAR), 2));
        $this->customer->addRental(new Rental(new Movie("Eraserhead", Movie::REGULAR), 3));

        $this->assertThat($this->customer->statement(),
            $this->equalTo("Rental Record for Fred\n\tPlan 9 from Outer Space\t2.0\n\t8 1/2\t2.0\n\tEraserhead\t3.5\nYou owed 7.5\nYou earned 3 frequent renter points\n"));
    }

}
