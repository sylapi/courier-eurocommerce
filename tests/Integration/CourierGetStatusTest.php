<?php

namespace Sylapi\Courier\Eurocommerce\Tests;

use Sylapi\Courier\Exceptions\TransportException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Eurocommerce\CourierGetStatuses;
use Sylapi\Courier\Eurocommerce\Responses\Parcel;
use Sylapi\Courier\Eurocommerce\Tests\Helpers\SessionTrait;

class CourierGetStatusTest extends PHPUnitTestCase
{
    use SessionTrait;

    public function testGetStatusSuccess()
    {
        $clientMock = $this->getClientMock();
        $sessionMock = $this->getSessionMock($clientMock);

        $courierPostShipment = new CourierGetStatuses($sessionMock);
        $response = $courierPostShipment->getStatus('123456');

        $this->assertInstanceOf(Parcel::class, $response);
    }

    public function testGetStatusFailure()
    {
        $clientMock = $this->getClientMock(true);
        $sessionMock = $this->getSessionMock($clientMock);

        $this->expectException(TransportException::class);
        $courierPostShipment = new CourierGetStatuses($sessionMock);
        $response = $courierPostShipment->getStatus('123456');
    }
}