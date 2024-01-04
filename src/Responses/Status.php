<?php

namespace Sylapi\Courier\Eurocommerce\Responses;

use Sylapi\Courier\Responses\Status as StatusResponse;

class Status extends StatusResponse
{
    private string $carrier;
    private string $original;
    private string $addData;
    private string $sentDate;
    private string $deliveryDate;

    
    public function setCarrier(string $carrier): StatusResponse
    {
        $this->carrier = $carrier;

        return $this;
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

    public function setOriginal(string $original): StatusResponse
    {
        $this->original = $original;

        return $this;
    }

    public function getOriginal(): string
    {
        return $this->original;
    }

    public function setAddData(string $addData): StatusResponse
    {
        $this->addData = $addData;

        return $this;
    }

    public function getAddData(): string
    {
        return $this->addData;
    }

    public function setSentDate(string $sentDate): StatusResponse
    {
        $this->sentDate = $sentDate;

        return $this;
    }

    public function getSentDate(): string
    {
        return $this->sentDate;
    }

    public function setDeliveryDate(string $deliveryDate): StatusResponse
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getDeliveryDate(): string
    {
        return $this->deliveryDate;
    }
}

