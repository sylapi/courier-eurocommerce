<?php

namespace Sylapi\Courier\Eurocommerce\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Contracts\Status;
use Sylapi\Courier\Eurocommerce\EurocommerceCourierGetStatuses;
use Sylapi\Courier\Eurocommerce\Tests\Helpers\EurocommerceSessionTrait;

class  CourierGetStatusTest extends PHPUnitTestCase
{
    use EurocommerceSessionTrait;

    public function testGetStatusSuccess()
    {
        $clientMock = $this->getClientMock();
        $sessionMock = $this->getSessionMock($clientMock);

        $courierPostShipment = new EurocommerceCourierGetStatuses($sessionMock);
        $response = $courierPostShipment->getStatus('123456');

        $this->assertInstanceOf(Status::class, $response);
    }

    public function testGetStatusFailure()
    {
        $clientMock = $this->getClientMock(true);
        $sessionMock = $this->getSessionMock($clientMock);

        $courierPostShipment = new EurocommerceCourierGetStatuses($sessionMock);
        $response = $courierPostShipment->getStatus('123456');

        $this->assertInstanceOf(Status::class, $response);
        $this->assertTrue($response->hasErrors());
    }
}