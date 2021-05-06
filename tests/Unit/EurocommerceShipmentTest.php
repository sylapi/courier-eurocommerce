<?php

namespace Sylapi\Courier\Eurocommerce\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Eurocommerce\EurocommerceParcel;
use Sylapi\Courier\Eurocommerce\EurocommerceReceiver;
use Sylapi\Courier\Eurocommerce\EurocommerceSender;
use Sylapi\Courier\Eurocommerce\EurocommerceShipment;

class EurocommerceShipmentTest extends PHPUnitTestCase
{
    public function testNumberOfPackagesIsAlwaysEqualTo1(): void
    {
        $parcel = new EurocommerceParcel();
        $shipment = new EurocommerceShipment();
        $shipment->setParcel($parcel);
        $shipment->setParcel($parcel);

        $this->assertEquals(1, $shipment->getQuantity());
    }

    public function testShipmentValidate(): void
    {
        $receiver = new EurocommerceReceiver();
        $sender = new EurocommerceSender();
        $parcel = new EurocommerceParcel();

        $shipment = new EurocommerceShipment();
        $shipment->setSender($sender)
            ->setReceiver($receiver)
            ->setParcel($parcel);

        $this->assertIsBool($shipment->validate());
        $this->assertIsBool($shipment->getReceiver()->validate());
        $this->assertIsBool($shipment->getSender()->validate());
        $this->assertIsBool($shipment->getParcel()->validate());
    }
}
