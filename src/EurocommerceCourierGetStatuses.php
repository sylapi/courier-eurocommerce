<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Entities\Status;
use Sylapi\Courier\Enums\StatusType;
use Sylapi\Courier\Helpers\ResponseHelper;
use Sylapi\Courier\Contracts\CourierGetStatuses;
use Sylapi\Courier\Contracts\Status as StatusContract;


class EurocommerceCourierGetStatuses implements CourierGetStatuses
{
    private $session;

    public function __construct(EurocommerceSession $session)
    {
        $this->session = $session;
    }

    public function getStatus(string $shipmentId): StatusContract
    {
        $client = $this->session->client();
        try {
            $result = $client->orders()->get((int) $shipmentId);
            $parcels = (array) $result->getParcels();
            if(!isset($parcels[0])) {
                $response = new Status(StatusType::NEW);
            }
            $parcel = $parcels[0];
            return new Status((string) new EurocommerceStatusTransformer($parcel->getStatus()));

        } catch (\Exception $e) {            
            $response = new Status(StatusType::APP_RESPONSE_ERROR);
            ResponseHelper::pushErrorsToResponse($response, [$e]);
        }
    
        return $response;   
    }
}
