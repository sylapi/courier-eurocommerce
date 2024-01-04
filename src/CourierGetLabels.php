<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Contracts\CourierGetLabels as CourierGetLabelsContract;
use Sylapi\Courier\Contracts\Label as LabelContract;
use Sylapi\Courier\Exceptions\UnavailableMethodException;
use Sylapi\Courier\Contracts\LabelType as LabelTypeContract;

class CourierGetLabels implements CourierGetLabelsContract
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getLabel(string $shipmentId, LabelTypeContract $labelType): LabelContract
    {
        throw new UnavailableMethodException('UnavailableMethodException');
    }
}
