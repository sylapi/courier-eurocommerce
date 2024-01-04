<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Contracts\CourierMakeReceiver;
use Sylapi\Courier\Contracts\Receiver;

class  CourierMakeReceiver implements CourierMakeReceiver
{
    public function makeReceiver(): Receiver
    {
        return new EurocommerceReceiver();
    }
}
