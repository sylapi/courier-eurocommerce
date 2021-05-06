<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Contracts\CourierGetLabels;
use Sylapi\Courier\Contracts\Label as LabelContract;
use Sylapi\Courier\Entities\Label;
use Sylapi\Courier\Exceptions\UnavailableMethodException;

class EurocommerceCourierGetLabels implements CourierGetLabels
{
    private $session;

    public function __construct(EurocommerceSession $session)
    {
        $this->session = $session;
    }

    public function getLabel(string $shipmentId): LabelContract
    {
        throw new UnavailableMethodException('UnavailableMethodException');
        /** @phpstan-ignore-next-line */
        return new Label(null);
    }
}
