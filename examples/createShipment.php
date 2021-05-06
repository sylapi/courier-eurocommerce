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
 * CreateShipment.
 */
$sender = $courier->makeSender();
$sender->setFullName('Nazwa Firmy/Nadawca')
    ->setStreet('Ulica')
    ->setHouseNumber('2a')
    ->setApartmentNumber('1')
    ->setCity('Miasto')
    ->setZipCode('66100')
    ->setCountry('Poland')
    ->setCountryCode('cz')
    ->setContactPerson('Jan Kowalski')
    ->setEmail('login@email.com')
    ->setPhone('48500600700');

$receiver = $courier->makeReceiver();
$receiver->setFirstName('Jan')
    ->setSurname('Nowak')
    ->setStreet('Vysoká')
    ->setHouseNumber('15')
    ->setApartmentNumber('1896')
    ->setCity('Ostrava')
    ->setZipCode('70200')
    ->setCountry('Czechy')
    ->setCountryCode('cz')
    ->setContactPerson('Jan Kowalski')
    ->setEmail('login@email.com')
    ->setPhone('48500600700');

$parcel = $courier->makeParcel();
$parcel->setWeight(2.5)
    ->setLength(3)
    ->setWidth(2)
    ->setHeight(5);

$shipment = $courier->makeShipment();
$shipment->setSender($sender)
    ->setReceiver($receiver)
    ->setParcel($parcel)
    ->setProducts([
        [
            'productId' => '377798',
            'refId' => '980',
            'additionalId' => '387',
            'quantity' => 1
        ],
        [
            'productId' => '377800',
            'refId' => '279',
            'additionalId' => '350',
            'quantity' => 1
        ]
    ])    
    ->setContent('Zawartość przesyłki');

try {
    $response = $courier->createShipment($shipment);
    if ($response->hasErrors()) {
        var_dump($response->getFirstError()->getMessage());
    } else {
        var_dump($response->referenceId); // Utworzony wewnetrzny idetyfikator zamowienia
        var_dump($response->shipmentId); // Zewnetrzny idetyfikator zamowienia
    }
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
