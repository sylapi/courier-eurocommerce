<?php

namespace Sylapi\Courier\Eurocommerce\Tests\Helpers;


use Sylapi\EurocommerceLinker\Api;
use Sylapi\EurocommerceLinker\Entities;
use Sylapi\Courier\Eurocommerce\Session;
use Sylapi\EurocommerceLinker\Exceptions\TransportException;

trait SessionTrait
{
    private function getClientMock($apiFailure = false)
    {

        $entityOrder = $this->createMock(Entities\Order::class);
        $entityOrder->method('getId')->willReturn(rand(1,1000000));

        $apiMake = $this->createMock(Entities\Make::class);
        $apiMake->method('order')->willReturn($entityOrder);
        $apiMake->method('delivery')->willReturn($this->createMock(Entities\Delivery::class));
        $apiMake->method('position')->willReturn($this->createMock(Entities\Position::class));

        $apiOrders = $this->createMock(Api\Orders::class);

        if($apiFailure) {
            $apiOrders->method('get')->willThrowException(new TransportException());
            $apiOrders->method('create')->willThrowException(new TransportException());
        } else {
            $apiOrders->method('get')->willReturn($entityOrder);
            $apiOrders->method('create')->willReturn($entityOrder);
        }
        
        $client = $this->createMock(Api::class);
        $client->method('orders')->willReturn($apiOrders);
        $client->method('make')->willReturn($apiMake);
        return $client;
    }

    private function getSessionMock($clientMock)
    {
        $sessionMock = $this->createMock(Session::class);
        $sessionMock->method('client')
            ->willReturn($clientMock);

        return $sessionMock;
    }
}