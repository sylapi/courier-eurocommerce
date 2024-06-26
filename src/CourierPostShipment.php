<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Contracts\Booking;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\EurocommerceLinker\Enums\OrderStatusType;
use Sylapi\Courier\Eurocommerce\Responses\Parcel as ParcelResponse;
use Sylapi\Courier\Contracts\CourierPostShipment as CourierPostShipmentContract;
use Sylapi\Courier\Responses\Parcel as ResponseParcel;

class CourierPostShipment implements CourierPostShipmentContract
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function postShipment(Booking $booking): ResponseParcel
    {
        $client = $this->session->client();
        $response = new ParcelResponse();
        try {
            $order = $client->orders()->get((int) $booking->getShipmentId());
            $order->setStatus(OrderStatusType::TRANSFERRED); 
            $result = $client->orders()->update($order);
            $response->setResponse($result);
            $response->setShipmentId((string) $result->getId());
            return $response;
        } catch (\Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }
    }
}
