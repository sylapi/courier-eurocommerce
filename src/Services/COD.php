<?php

namespace Sylapi\Courier\Eurocommerce\Services;

use Sylapi\Courier\Abstracts\Services\COD as CODAbstract;

class COD extends CODAbstract
{
    public function handle(): array
    {    
        return [
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
        ];
    }
}
