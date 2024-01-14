<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Responses\Label as ResponseLabel;
use Sylapi\Courier\Eurocommerce\Responses\Label as LabelResponse;
use Sylapi\Courier\Exceptions\UnavailableMethodException;
use Sylapi\Courier\Contracts\LabelType as LabelTypeContract;
use Sylapi\Courier\Contracts\CourierGetLabels as CourierGetLabelsContract;


class CourierGetLabels implements CourierGetLabelsContract
{

    
    public function __construct(readonly private Session $session) { /* @phpstan-ignore-line */  
    }

    public function getLabel(string $shipmentId, LabelTypeContract $labelType): ResponseLabel
    {
        throw new UnavailableMethodException('UnavailableMethodException');
        
        return new LabelResponse(null); /* @phpstan-ignore-line */  
    }
}
