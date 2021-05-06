<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Abstracts\StatusTransformer;
use Sylapi\Courier\Enums\StatusType;

class EurocommerceStatusTransformer extends StatusTransformer
{
    /**
     * @var array<string, string>
     */
    public $statuses = [
        'PACKED' => StatusType::WAREHOUSE_ENTRY,
        'SENT' => StatusType::SENT,
        'DELIVERED' => StatusType::DELIVERED,
        'CANCELLED' => StatusType::CANCELLED,
        'PICKUP_READY' => StatusType::PICKUP_READY,
        'OTHER' => StatusType::APP_UNAVAILABLE
    ];
}
