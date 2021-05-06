<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Courier;

class EurocommerceCourierApiFactory
{
    private $eurocommerceSessionFactory;

    public function __construct(EurocommerceSessionFactory $eurocommerceSessionFactory)
    {
        $this->eurocommerceSessionFactory = $eurocommerceSessionFactory;
    }

    public function create(array $parameters): Courier
    {
        $session = $this->eurocommerceSessionFactory
                    ->session(EurocommerceParameters::create($parameters));

        return new Courier(
            new EurocommerceCourierCreateShipment($session),
            new EurocommerceCourierPostShipment($session),
            new EurocommerceCourierGetLabels($session),
            new EurocommerceCourierGetStatuses($session),
            new EurocommerceCourierMakeShipment(),
            new EurocommerceCourierMakeParcel(),
            new EurocommerceCourierMakeReceiver(),
            new EurocommerceCourierMakeSender(),
            new EurocommerceCourierMakeBooking()
        );
    }
}
