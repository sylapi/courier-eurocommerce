<?php

namespace Sylapi\Courier\Eurocommerce\Tests;

use Sylapi\Courier\Contracts\Response;
use Sylapi\EurocommerceLinker\Enums\CarierType;
use Sylapi\Courier\Eurocommerce\Entities\Parcel;
use Sylapi\Courier\Eurocommerce\Entities\Sender;
use Sylapi\Courier\Eurocommerce\Entities\Options;
use Sylapi\Courier\Exceptions\TransportException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Eurocommerce\Entities\Receiver;
use Sylapi\Courier\Eurocommerce\Entities\Shipment;
use Sylapi\Courier\Eurocommerce\CourierCreateShipment;
use Sylapi\Courier\Eurocommerce\Tests\Helpers\SessionTrait;
use Sylapi\Courier\Eurocommerce\Responses\Shipment as ResponsesShipment;

class CourierCreateShipmentTest extends PHPUnitTestCase
{
    use SessionTrait;

    private function getShipmentMock()
    {
        $senderMock = $this->createMock(Sender::class);
        $receiverMock = $this->createMock(Receiver::class);
        $parcelMock = $this->createMock(Parcel::class);
        $optionsMock = $this->createMock(Options::class);
        $optionsMock->method('getShippingType')->willReturn(CarierType::POCZTK48ST);
        $shipmentMock = $this->createMock(Shipment::class);
        

        $shipmentMock->method('getSender')
                ->willReturn($senderMock);

        $shipmentMock->method('getReceiver')
                ->willReturn($receiverMock);

        $shipmentMock->method('getParcel')
                ->willReturn($parcelMock);
        
        $shipmentMock->method('getOptions')
                ->willReturn($optionsMock);

        $shipmentMock->method('validate')
                ->willReturn(true);

        return $shipmentMock;
    }

    public function testCreateShipmentSuccess()
    {
        $clientMock = $this->getClientMock();
        $sessionMock = $this->getSessionMock($clientMock);

        $courierCreateShipment = new CourierCreateShipment($sessionMock);
        $response = $courierCreateShipment->createShipment($this->getShipmentMock());

        $this->assertInstanceOf(ResponsesShipment::class, $response);
        $this->assertIsString($response->getShipmentId());
    }

    public function testCreateShipmentFailure()
    {
        $clientMock = $this->getClientMock(true);
        $sessionMock = $this->getSessionMock($clientMock);

        $this->expectException(TransportException::class);
        $courierCreateShipment = new CourierCreateShipment($sessionMock);
        $courierCreateShipment->createShipment($this->getShipmentMock());
    }
}