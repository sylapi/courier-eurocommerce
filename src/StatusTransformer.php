<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Abstracts\StatusTransformer as StatusTransformerAbstract;
use Sylapi\Courier\Enums\StatusType;

class StatusTransformer extends StatusTransformerAbstract
{
    /**
     * @var array<string, string>
     */
    public $statuses = [
        'PACKED' => StatusType::WAREHOUSE_ENTRY->value,
        'SENT' => StatusType::SENT->value,
        'DELIVERED' => StatusType::DELIVERED->value,
        'CANCELLED' => StatusType::CANCELLED->value,
        'PICKUP_READY' => StatusType::PICKUP_READY->value,
        'OTHER' => StatusType::APP_UNAVAILABLE->value
    ];
}
