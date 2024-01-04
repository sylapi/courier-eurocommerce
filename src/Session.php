<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\EurocommerceLinker\ApiFactory;
use Sylapi\EurocommerceLinker\Parameters;
use Sylapi\EurocommerceLinker\SessionFactory;
use Sylapi\Courier\Eurocommerce\Entities\Credentials;
use Sylapi\EurocommerceLinker\Api as Client;


class Session
{
    private $credentials;
    private $client;

    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
        $this->client = null;
    }

    public function client(): Client
    {
        if (!$this->client) {
            $this->client = $this->initializeSession();
        }

        return $this->client;
    }

    private function initializeSession(): Client
    {
        $gateway = new ApiFactory(
            new SessionFactory()
        );

        $parameters = Parameters::create([
            'login' => $this->credentials->getLogin(),
            'password' => $this->credentials->getPassword(),
            'debug' => $this->credentials->isSandbox()
        ]);

        $this->client = $gateway->create($parameters);

        return $this->client;
    }
}
