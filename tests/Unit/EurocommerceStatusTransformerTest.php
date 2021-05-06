<?php

namespace Sylapi\Courier\Eurocommerce\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Enums\StatusType;
use Sylapi\Courier\Eurocommerce\EurocommerceStatusTransformer;

class EurocommerceStatusTransformerTest extends PHPUnitTestCase
{
    public function testStatusTransformer(): void
    {
        $eurocommerceStatusTransformer = new EurocommerceStatusTransformer('PACKED');
        $this->assertEquals(StatusType::WAREHOUSE_ENTRY, (string) $eurocommerceStatusTransformer);
    }
}
