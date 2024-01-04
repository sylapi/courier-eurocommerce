<?php

namespace Sylapi\Courier\Eurocommerce\Tests;

use Sylapi\Courier\Eurocommerce\Responses\Parcel as ParcelResponse;
use Sylapi\Courier\Eurocommerce\Entities\Booking;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Eurocommerce\CourierPostShipment;
use Sylapi\Courier\Eurocommerce\Tests\Helpers\SessionTrait;
use Sylapi\Courier\Exceptions\TransportException;


class CourierPostShipmentTest extends PHPUnitTestCase
{
    use SessionTrait;

    public function testPostShipmentSuccess()
    {
        $clientMock = $this->getClientMock();
        $sessionMock = $this->getSessionMock($clientMock);

        $shipmentId = rand(1,1000000);
        $bookingMock = $this->createMock(Booking::class);
        $bookingMock->method('getShipmentId')->willReturn($shipmentId);


        $courierPostShipment = new CourierPostShipment($sessionMock);
        $response = $courierPostShipment->postShipment($bookingMock);

        $this->assertInstanceOf(ParcelResponse::class, $response);
        $this->assertIsString($response->getShipmentId());
    }

    public function testCreateShipmentFailure()
    {
        $clientMock = $this->getClientMock(true);
        $sessionMock = $this->getSessionMock($clientMock);

        $bookingMock = $this->createMock(Booking::class);
        $bookingMock->method('getShipmentId')->willReturn(rand(1,1000000));

        $this->expectException(TransportException::class);
        $courierPostShipment = new CourierPostShipment($sessionMock);
        $courierPostShipment->postShipment($bookingMock);
    }
}