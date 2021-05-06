<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Rakit\Validation\Validator;
use Sylapi\Courier\Abstracts\Parcel;

class EurocommerceParcel extends Parcel
{
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
