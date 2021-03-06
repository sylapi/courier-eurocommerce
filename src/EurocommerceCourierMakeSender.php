<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Contracts\CourierMakeSender;
use Sylapi\Courier\Contracts\Sender;

class EurocommerceCourierMakeSender implements CourierMakeSender
{
    public function makeSender(): Sender
    {
        return new EurocommerceSender();
    }
}
