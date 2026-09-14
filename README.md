# ArtisanPack UI Shipping Labels

Carrier-agnostic shipping label engine for Laravel. Ships a `LabelProvider` contract, a `Label` Eloquent model, and a `LabelProviderRegistry` so that satellite packages (Shippo, EasyPost, USPS, ShipStation, …) can plug carrier drivers into any Laravel application.

This is a **peer package** — it has no dependency on `artisanpack-ui/ecommerce` and can be used from any Laravel project that needs to buy, void, and track carrier labels.

## Installation

```
composer require artisanpack-ui/shipping-labels
```

Publish and run the migrations:

```
php artisan vendor:publish --tag=shipping-labels-migrations
php artisan migrate
```

## Usage

Resolve the registry and register a driver:

```php
use ArtisanPackUI\ShippingLabels\Registries\LabelProviderRegistry;
use ArtisanPackUI\ShippingLabels\Providers\NullLabelProvider;

app( LabelProviderRegistry::class )->register( new NullLabelProvider() );
```

Buy a label:

```php
use ArtisanPackUI\ShippingLabels\Support\LabelPurchaseRequest;
use ArtisanPackUI\ShippingLabels\Support\Address;
use ArtisanPackUI\ShippingLabels\Support\Parcel;

$request = new LabelPurchaseRequest(
    from: Address::fromArray( [ /* ... */ ] ),
    to:   Address::fromArray( [ /* ... */ ] ),
    parcel: new Parcel( weightGrams: 500, lengthMm: 200, widthMm: 150, heightMm: 100 ),
    service: 'usps_priority',
);

$label = app( LabelProviderRegistry::class )
    ->get( 'null' )
    ->buyLabel( $request );
```

Void or track the label:

```php
$provider->voidLabel( $label );

$status = $provider->trackLabel( $label );
```

## Writing a driver satellite

1. Implement `ArtisanPackUI\ShippingLabels\Contracts\LabelProvider`.
2. Register your provider in the driver's service provider using `LabelProviderRegistry::register()`.
3. Extend `ArtisanPackUI\ShippingLabels\Testing\LabelProviderContractTestCase` to validate the driver against the shared contract.

## Contributing

As an open source project, this package is open to contributions from anyone. Please [read through the contributing
guidelines](CONTRIBUTING.md) to learn more about how you can contribute to this project.
