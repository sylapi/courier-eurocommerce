<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\EurocommerceLinker\ApiFactory;
use Sylapi\EurocommerceLinker\Parameters;
use Sylapi\EurocommerceLinker\SessionFactory;

class EurocommerceSession
{
    private $parameters;
    private $client;

    public function __construct(EurocommerceParameters $parameters)
    {
        $this->parameters = $parameters;
    }

    public function parameters(): EurocommerceParameters
    {
        return $this->parameters;
    }

    public function client()
    {
        if (!$this->client) {
            $this->initializeSession();
        }

        return $this->client;
    }

    private function initializeSession(): void
    {
        $gateway = new ApiFactory(
            new SessionFactory()
        );

        $parameters = Parameters::create([
            'login' => $this->parameters()->login ?? null,
            'password' => $this->parameters()->password ?? null,
            'debug' => $this->parameters()->sandbox ?? false
        ]);

        $this->client = $gateway->create($parameters);

    }
}
