<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Contracts\Shipment;
use Sylapi\Courier\Eurocommerce\Entities\Shipment as ShipmentEntity;
use Sylapi\Courier\Helpers\ReferenceHelper;
use Sylapi\EurocommerceLinker\Entities\Order;
use Sylapi\EurocommerceLinker\Enums\CarierType;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\EurocommerceLinker\Enums\OrderStatusType;
use Sylapi\Courier\Contracts\Response as ResponseContract;
use Sylapi\Courier\Eurocommerce\Responses\Shipment as ShipmentResponse;
use Sylapi\Courier\Contracts\CourierCreateShipment as CourierCreateShipmentContract;

class CourierCreateShipment implements CourierCreateShipmentContract
{

    const ORDER_STATUS = OrderStatusType::DRAFT;
    const ORDER_SOURCE = 'api';

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function createShipment(Shipment $shipment): ResponseContract
    {
        $client = $this->session->client();
        $response = new ShipmentResponse();
        $request = $this->request($shipment);

        try {
            $result = $client->orders()->create($request);
            $response->setShipmentId((string) $result->getId());
            return $response;
            
        } catch (\Exception $e) {
            throw new TransportException($e->getMessage(), $e->getCode());
        }
    }

    private function request(Shipment $shipment): Order
    {
        $client = $this->session->client();
        $options = $shipment->getOptions();

        $delivery = $client->make()->delivery();
        $delivery->setCarier(CarierType::POCZTK48OP);

        //TODO: Services
        /*
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
        */
        /**
         * @var ShipmentEntity $shipment
         */

        $products = (array) $shipment->getProducts();
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
