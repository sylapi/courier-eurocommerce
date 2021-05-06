<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Contracts\CourierMakeParcel;
use Sylapi\Courier\Contracts\Parcel;

class EurocommerceCourierMakeParcel implements CourierMakeParcel
{
    public function makeParcel(): Parcel
    {
        return new EurocommerceParcel();
    }
}
