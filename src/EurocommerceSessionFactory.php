<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

class EurocommerceSessionFactory
{
    private $sessions = [];
    
    private $parameters;

    public function session(EurocommerceParameters $parameters): EurocommerceSession
    {
        $this->parameters = $parameters;
       
        $key = sha1($this->parameters->login.':'.$this->parameters->password);

        return (isset($this->sessions[$key])) ? $this->sessions[$key] : ($this->sessions[$key] = new EurocommerceSession($this->parameters));
    }
}
