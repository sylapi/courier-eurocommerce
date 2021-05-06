<?php

use Sylapi\Courier\CourierFactory;

$courier = CourierFactory::create('Eurocommerce', [
    'login'           => 'mylogin',
    'password'        => 'mypassword',
    'speditionCode' => CarierType::POCZTK48OP,
    'pickupPlaceId' => '11111',
    'cod' => [
        'amount' => 25.50,
        'currency' => 'PLN'
    ]
]);

/**
 * GetStatus.
 */
try {
    $response = $courier->getStatus('123456');
    if ($response->hasErrors()) {
        var_dump($response->getFirstError()->getMessage());
    } else {
        var_dump((string) $response);
    }
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
