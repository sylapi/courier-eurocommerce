<?php

namespace Sylapi\Courier\Eurocommerce\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Courier;
use Sylapi\Courier\Eurocommerce\EurocommerceBooking;
use Sylapi\Courier\Eurocommerce\EurocommerceCourierApiFactory;
use Sylapi\Courier\Eurocommerce\EurocommerceParameters;
use Sylapi\Courier\Eurocommerce\EurocommerceParcel;
use Sylapi\Courier\Eurocommerce\EurocommerceReceiver;
use Sylapi\Courier\Eurocommerce\EurocommerceSender;
use Sylapi\Courier\Eurocommerce\EurocommerceSession;
use Sylapi\Courier\Eurocommerce\EurocommerceSessionFactory;
use Sylapi\Courier\Eurocommerce\EurocommerceShipment;

class  CourierApiFactoryTest extends PHPUnitTestCase
{
    /**
     * @var array<string,mixed>
     */
    private $parameters = [
        'login'           => 'login',
        'password'        => 'password',
        'sandbox'         => true,
    ];

    public function testEurocommerceSessionFactory(): void
    {
        $eurocommerceSessionFactory = new EurocommerceSessionFactory();
        $eurocommerceSession = $eurocommerceSessionFactory->session(
            EurocommerceParameters::create($this->parameters)
        );
        $this->assertInstanceOf(EurocommerceSession::class, $eurocommerceSession);
    }

    public function testCourierFactoryCreate(): void
    {
        $eurocommerceCourierApiFactory = new EurocommerceCourierApiFactory(new EurocommerceSessionFactory());
        $courier = $eurocommerceCourierApiFactory->create($this->parameters);

        $this->assertInstanceOf(Courier::class, $courier);
        $this->assertInstanceOf(EurocommerceBooking::class, $courier->makeBooking());
        $this->assertInstanceOf(EurocommerceParcel::class, $courier->makeParcel());
        $this->assertInstanceOf(EurocommerceReceiver::class, $courier->makeReceiver());
        $this->assertInstanceOf(EurocommerceSender::class, $courier->makeSender());
        $this->assertInstanceOf(EurocommerceShipment::class, $courier->makeShipment());
    }
}
