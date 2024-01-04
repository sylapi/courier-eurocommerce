<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Eurocommerce\Responses\Status as StatusResponse;
use Sylapi\Courier\Enums\StatusType;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Contracts\CourierGetStatuses as CourierGetStatusesContract;
use Sylapi\Courier\Contracts\Response as ResponseContract;

class CourierGetStatuses implements CourierGetStatusesContract
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function getStatus(string $shipmentId): ResponseContract
    {
        $client = $this->session->client();
        try {
            $result = $client->orders()->get((int) $shipmentId);
            $parcels = (array) $result->getParcels();
            if(!isset($parcels[0])) {
                return new StatusResponse(StatusType::NEW->value);
            }
            $parcel = $parcels[0];
            $status =  new StatusResponse((string) new StatusTransformer($parcel->getStatus()));
            $status->setCarrier($parcel->getCarrier());
            $status->setOriginal($parcel->getOriginalStatus());
            $status->setAddData($parcel->getAddData());
            $status->setSentDate($parcel->getSentDate());
            $status->setDeliveryDate($parcel->getDeliveryDate());
            return $status;
        } catch (\Exception $e) {            
            throw new TransportException($e->getMessage(), $e->getCode());
        }   
    }
}
