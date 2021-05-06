<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Rakit\Validation\Validator;
use Sylapi\Courier\Abstracts\Sender;

class EurocommerceSender extends Sender
{
    public function validate(): bool
    {
        $rules = [
        ];

        $data = $this->toArray();

        $validator = new Validator();

        $validation = $validator->validate($data, $rules);
        if ($validation->fails()) {
            $this->setErrors($validation->errors()->toArray());

            return false;
        }

        return true;
    }
}
