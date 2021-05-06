<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use ArrayObject;
use Rakit\Validation\Validator;
use Sylapi\Courier\Contracts\Validatable as ValidatableContract;
use Sylapi\Courier\Traits\Validatable;

class EurocommerceParameters extends ArrayObject implements ValidatableContract
{
    use Validatable;

    /**
     * @param array<string, mixed> $parameters
     */
    public static function create(array $parameters): self
    {
        return new self($parameters, ArrayObject::ARRAY_AS_PROPS);
    }


    public function hasProperty(string $name)
    {
        return property_exists($this, $name);
    }

    public function validate(): bool
    {
        $rules = [

        ];
        $data = [

        ];

        $validator = new Validator();

        $validation = $validator->validate($data, $rules);
        if ($validation->fails()) {
            $this->setErrors($validation->errors()->toArray());

            return false;
        }

        return true;
    }
}
