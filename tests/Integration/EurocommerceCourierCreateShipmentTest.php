<?php

namespace Sylapi\Courier\Eurocommerce\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Contracts\Response;
use Sylapi\Courier\Eurocommerce\EurocommerceCourierCreateShipment;
use Sylapi\Courier\Eurocommerce\EurocommerceParcel;
use Sylapi\Courier\Eurocommerce\EurocommerceReceiver;
use Sylapi\Courier\Eurocommerce\EurocommerceSender;
use Sylapi\Courier\Eurocommerce\EurocommerceShipment;
use Sylapi\Courier\Eurocommerce\Tests\Helpers\EurocommerceSessionTrait;

class EurocommerceCourierCreateShipmentTest extends PHPUnitTestCase
{
    use EurocommerceSessionTrait;

    private function getShipmentMock()
    {
        $senderMock = $this->createMock(EurocommerceSender::class);
        $receiverMock = $this->createMock(EurocommerceReceiver::class);
        $parcelMock = $this->createMock(EurocommerceParcel::class);
        $shipmentMock = $this->createMock(EurocommerceShipment::class);

        $shipmentMock->method('getSender')
                ->willReturn($senderMock);

        $shipmentMock->method('getReceiver')
                ->willReturn($receiverMock);

        $shipmentMock->method('getParcel')
                ->willReturn($parcelMock);

        $shipmentMock->method('validate')
                ->willReturn(true);

        return $shipmentMock;
    }

    public function testCreateShipmentSuccess()
    {
        $clientMock = $this->getClientMock();
        $sessionMock = $this->getSessionMock($clientMock);

        $courierCreateShipment = new EurocommerceCourierCreateShipment($sessionMock);
        $response = $courierCreateShipment->createShipment($this->getShipmentMock());

        $this->assertInstanceOf(Response::class, $response);
        $this->assertObjectHasAttribute('shipmentId', $response);
        $this->assertNotEmpty($response->shipmentId);
    }

    public function testCreateShipmentFailure()
    {
        $clientMock = $this->getClientMock(true);
        $sessionMock = $this->getSessionMock($clientMock);

        $courierCreateShipment = new EurocommerceCourierCreateShipment($sessionMock);
        $response = $courierCreateShipment->createShipment($this->getShipmentMock());

        $this->assertInstanceOf(Response::class, $response);
        $this->assertTrue($response->hasErrors());
    }
}