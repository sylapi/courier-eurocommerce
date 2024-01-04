<?php

namespace Sylapi\Courier\Eurocommerce\Tests\Unit;

use Sylapi\Courier\Enums\StatusType;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Eurocommerce\StatusTransformer;

class StatusTransformerTest extends PHPUnitTestCase
{
    public function testStatusTransformer(): void
    {
        $eurocommerceStatusTransformer = new StatusTransformer('PACKED');
        $this->assertEquals(StatusType::WAREHOUSE_ENTRY->value, (string) $eurocommerceStatusTransformer);
    }
}
