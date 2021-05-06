<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Contracts\Booking;
use Sylapi\Courier\Contracts\CourierMakeBooking;

class EurocommerceCourierMakeBooking implements CourierMakeBooking
{
    public function makeBooking(): Booking
    {
        return new EurocommerceBooking();
    }
}
