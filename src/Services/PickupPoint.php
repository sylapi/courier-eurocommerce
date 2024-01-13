<?php

namespace Sylapi\Courier\Eurocommerce\Services;

use Sylapi\Courier\Abstracts\Services\PickupPoint as PickupPointAbstract;

class PickupPoint extends PickupPointAbstract
{

    public function handle(): array
    {        
        return [
            'pickupId' => $this->getPickupId(),
        ];
    }
}
