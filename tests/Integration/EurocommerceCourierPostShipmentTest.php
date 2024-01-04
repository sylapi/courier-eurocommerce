<?php

namespace Sylapi\Courier\Eurocommerce\Tests;

use Sylapi\Courier\Contracts\Response;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Eurocommerce\EurocommerceBooking;
use Sylapi\Courier\Eurocommerce\EurocommerceCourierPostShipment;
use Sylapi\Courier\Eurocommerce\Tests\Helpers\EurocommerceSessionTrait;

class  CourierPostShipmentTest extends PHPUnitTestCase
{
    use EurocommerceSessionTrait;

    public function testPostShipmentSuccess()
    {
        $clientMock = $this->getClientMock();
        $sessionMock = $this->getSessionMock($clientMock);

        $bookingMock = $this->createMock(EurocommerceBooking::class);
        $bookingMock->method('getShipmentId')->willReturn(rand(1,1000000));

        $courierPostShipment = new EurocommerceCourierPostShipment($sessionMock);
        $response = $courierPostShipment->postShipment($bookingMock);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertObjectHasAttribute('shipmentId', $response);
    }

    public function testCreateShipmentFailure()
    {
        $clientMock = $this->getClientMock(true);
        $sessionMock = $this->getSessionMock($clientMock);

        $bookingMock = $this->createMock(EurocommerceBooking::class);
        $bookingMock->method('getShipmentId')->willReturn(rand(1,1000000));

        $courierPostShipment = new EurocommerceCourierPostShipment($sessionMock);
        $response = $courierPostShipment->postShipment($bookingMock);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertTrue($response->hasErrors());
    }
}