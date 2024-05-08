<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce\Entities;

use Sylapi\Courier\Abstracts\Options as OptionsAbstract;

class Options extends OptionsAbstract
{
    public function getShippingType(): ?string
    {
        return $this->get('shippingType');
    }

    public function setShippingType(string $shippingType): self
    {
        $this->set('shippingType', $shippingType);
        return $this;
    }

    public function validate(): bool
    {
        return true;
    }
}
