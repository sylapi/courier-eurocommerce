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
 * PostShipment.
 */
$booking = $courier->makeBooking();
$booking->setShipmentId('123456');

try {
    $response = $courier->postShipment($booking);
    if ($response->hasErrors()) {
        var_dump($response->getFirstError()->getMessage());
    } else {
        var_dump($response->shipmentId); // Zewnetrzny idetyfikator zamowienia
    }
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
