<?php

namespace Sylapi\Courier\Eurocommerce\Tests\Unit;

use Sylapi\Courier\Courier;
use Sylapi\Courier\Eurocommerce\Session;
use Sylapi\Courier\Eurocommerce\SessionFactory;
use Sylapi\Courier\Eurocommerce\Entities\Parcel;
use Sylapi\Courier\Eurocommerce\Entities\Sender;
use Sylapi\Courier\Eurocommerce\Entities\Booking;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Eurocommerce\CourierApiFactory;
use Sylapi\Courier\Eurocommerce\Entities\Receiver;
use Sylapi\Courier\Eurocommerce\Entities\Shipment;
use Sylapi\Courier\Eurocommerce\Entities\Credentials;

class CourierApiFactoryTest extends PHPUnitTestCase
{
    public function testEurocommerceSessionFactory(): void
    {
        $credentials = new Credentials();
        $credentials->setLogin('login');
        $credentials->setPassword('password');
        $credentials->setSandbox(true);
        $sessionFactory = new SessionFactory();
        $session = $sessionFactory->session(
            $credentials
        );
        $this->assertInstanceOf(Session::class, $session);
    }

    public function testCourierFactoryCreate(): void
    {
        $credentials = [
            'login' => 'login',
            'password' => 'password',
            'sandbox' => true,
        ];

        $courierApiFactory = new CourierApiFactory(new SessionFactory());
        $courier = $courierApiFactory->create($credentials);

        $this->assertInstanceOf(Courier::class, $courier);
        $this->assertInstanceOf(Booking::class, $courier->makeBooking());
        $this->assertInstanceOf(Parcel::class, $courier->makeParcel());
        $this->assertInstanceOf(Receiver::class, $courier->makeReceiver());
        $this->assertInstanceOf(Sender::class, $courier->makeSender());
        $this->assertInstanceOf(Shipment::class, $courier->makeShipment());
    }
}
