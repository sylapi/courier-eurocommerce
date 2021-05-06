# Courier-eurocommerce

![StyleCI](https://github.styleci.io/repos/0000000/shield?style=flat&style=flat) ![PHPStan](https://img.shields.io/badge/PHPStan-level%205-brightgreen.svg?style=flat) [![Build](https://github.com/sylapi/courier-eurocommerce/actions/workflows/build.yaml/badge.svg?event=push)](https://github.com/sylapi/courier-eurocommerce/actions/workflows/build.yaml) [![codecov.io](https://codecov.io/github/sylapi/courier-eurocommerce/coverage.svg)](https://codecov.io/github/sylapi/courier-eurocommerce/)

## Methody

### Init

```php
    /**
    * @return Sylapi\Courier\Courier
    */
    $courier = CourierFactory::create('Eurocommerce',[
        'login' => 'mylogin',
        'password' => 'mypassword',
        'speditionCode' => CarierType::POCZTK48OP,
        'pickupPlaceId' => '11111',
        'cod' => [
            'amount' => 25.50,
            'currency' => 'PLN'
        ]
    ]);

```

### CreateShipment

```php
    $sender = $courier->makeSender();
    $sender->setFullName('Nazwa Firmy/Nadawca')
        ->setStreet('Ulica')
        ->setHouseNumber('2a')
        ->setApartmentNumber('1')
        ->setCity('Miasto')
        ->setZipCode('66100')
        ->setCountry('Poland')
        ->setCountryCode('pl')
        ->setContactPerson('Jan Kowalski')
        ->setEmail('my@email.com')
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
            ->setContent('Zawartość przesyłki')
            ;

    try {
        $response = $courier->createShipment($shipment);
        if($response->hasErrors()) {
            var_dump($response->getFirstError()->getMessage());
        } else {
            var_dump($response->referenceId); // Utworzony wewnetrzny idetyfikator zamowienia
            var_dump($response->shipmentId); // Zewnetrzny idetyfikator zamowienia
        }

    } catch (\Exception $e) {
        var_dump($e->getMessage());
    }
```

### PostShipment

```php
    /**
     * Init Courier
     */
    $booking = $courier->makeBooking();
    $booking->setShipmentId('123456');
    try {
        $response = $courier->postShipment($booking);
        if($response->hasErrors()) {
            var_dump($response->getFirstError()->getMessage());
        } else {
            var_dump($response->shipmentId); // Zewnetrzny idetyfikator zamowienia
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
    }
```

### GetStatus

```php
    /**
     * Init Courier
     */
    try {
        $response = $courier->getStatus('123456');
        if($response->hasErrors()) {
            var_dump($response->getFirstError()->getMessage());
        } else {
            var_dump((string) $response);
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
    }
```

## ENUMS

### SpeditionCode

| WARTOŚĆ | OPIS |
| ------ | ------ |
| GLSDEEUROB | GLS Niemcy i pozostałe kraje Europy. Przesyłka Euro Business Parcel |
| GLSPLSTAND | GLS Polska. Standardowa przesyłka |
| GLSCZSTAND | GLS Czechy. Standardowa przesyłka |
| POCZTK48ST | Pocztex. Przesyłka Kurier 48 |
| POCZTK48OP | Pocztex. Przesyłka Kurier 48 Odbiór w punkcie |
| POCZTPECOM | Pocztex. Polecony Ecommerce |
| INPOSPACZK | Inpost. Paczkomaty |

## Komendy

| KOMENDA | OPIS |
| ------ | ------ |
| composer tests | Testy |
| composer phpstan |  PHPStan |
| composer coverage | PHPUnit Coverage |
| composer coverage-html | PHPUnit Coverage HTML (DIR: ./coverage/) |
