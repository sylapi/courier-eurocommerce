<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Entities\Response;
use Sylapi\Courier\Contracts\Shipment;
use Sylapi\Courier\Helpers\ResponseHelper;
use Sylapi\EurocommerceLinker\Entities\Order;
use Sylapi\EurocommerceLinker\Enums\CarierType;
use Sylapi\Courier\Helpers\ReferenceHelper;
use Sylapi\Courier\Contracts\CourierCreateShipment;
use Sylapi\EurocommerceLinker\Enums\OrderStatusType;
use Sylapi\Courier\Contracts\Response as ResponseContract;

class EurocommerceCourierCreateShipment implements CourierCreateShipment
{

    const ORDER_STATUS = OrderStatusType::DRAFT;
    const ORDER_SOURCE = 'api';

    private $session;

    public function __construct(EurocommerceSession $session)
    {
        $this->session = $session;
    }

    public function createShipment(Shipment $shipment): ResponseContract
    {
        $client = $this->session->client();
        $response = new Response();
        $request = $this->request($shipment);

        try {
            $result = $client->orders()->create($request);

            $response->shipmentId = $result->getId();
            $response->trackingId = null;
            
        } catch (\Exception $e) {
            ResponseHelper::pushErrorsToResponse($response, [$e]);
        }

        return $response;
    }

    private function request(Shipment $shipment): Order
    {
        $client = $this->session->client();

        $delivery = $client->make()->delivery();
        $delivery->setCarier(CarierType::POCZTK48OP);

        if($this->session->parameters()->hasProperty('pickupPlaceId')) {
            $delivery->setAdditionalInfo($this->session->parameters()->pickupPlaceId);
        }

        if($this->session->parameters()->hasProperty('cod') 
            && is_array($this->session->parameters()->cod)
            && isset($this->session->parameters()->cod['amount'])
            && isset($this->session->parameters()->cod['currency'])
        ) {
            $delivery->setCurrencyCOD($this->session->parameters()->cod['currency'])
                ->setAmountCOD($this->session->parameters()->cod['amount']);
        }

        $products = (array) $shipment->getProducts(); /* @phpstan-ignore-line */   
        $positions = $client->make()->positions();
        foreach ($products as $product) {
            $position = $client->make()->position();
            $position
                ->setProductId((int) $product['productId'])
                ->setRefId((int) $product['refId'])
                ->setAdditionalId($product['additionalId'])
                ->setQuantity(1)
                ;
            
            $positions->add($position);
        }        

        $order = $client->make()->order();
        $order->setRefId(rand(100,999))
            ->setNumber(ReferenceHelper::generate())
            ->setSource(self::ORDER_SOURCE)
            ->setStatus(self::ORDER_STATUS)
            ->setDelivery($delivery)
            ->setContactPerson($shipment->getReceiver()->getContactPerson())
            ->setPhone($shipment->getReceiver()->getPhone())
            ->setEmail($shipment->getReceiver()->getEmail())
            ->setName1($shipment->getReceiver()->getFullName())
            ->setName2('')
            ->setName3('')
            ->setPostalCode($shipment->getReceiver()->getZipCode())
            ->setCountryCode($shipment->getReceiver()->getCountryCode())
            ->setPlace($shipment->getReceiver()->getCity())
            ->setStreet($shipment->getReceiver()->getStreet())
            ->setNote($shipment->getContent())
            ->setPositions($positions);

        return $order;
    }

}
