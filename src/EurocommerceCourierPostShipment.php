<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Contracts\Booking;
use Sylapi\Courier\Entities\Response;
use Sylapi\Courier\Helpers\ResponseHelper;
use Sylapi\Courier\Contracts\CourierPostShipment;
use Sylapi\EurocommerceLinker\Enums\OrderStatusType;
use Sylapi\Courier\Contracts\Response as ResponseContract;

class EurocommerceCourierPostShipment implements CourierPostShipment
{
    private $session;

    public function __construct(EurocommerceSession $session)
    {
        $this->session = $session;
    }

    public function postShipment(Booking $booking): ResponseContract
    {
        $client = $this->session->client();
        $response = new Response();
        try {
            $order = $client->orders()->get((int) $booking->getShipmentId());
            $order->setStatus(OrderStatusType::TRANSFERRED); 
            $result = $client->orders()->update($order);
            $response->shipmentId = $result->getId();
            $response->trackingId = null;
        } catch (\Exception $e) {
            ResponseHelper::pushErrorsToResponse($response, [$e]);
        }
        
        return $response;
    }
}
