<?php

declare( strict_types=1 );

use ArtisanPackUI\ShippingLabels\Support\Address;

it( 'builds an address from an array and round-trips it', function (): void {
    $address = Address::fromArray( [
        'name'        => 'Buyer Person',
        'line1'       => '456 Receiver Ave',
        'city'        => 'Austin',
        'region'      => 'TX',
        'postal_code' => '73301',
        'country'     => 'US',
    ] );

    expect( $address->name )->toBe( 'Buyer Person' )
        ->and( $address->postalCode )->toBe( '73301' )
        ->and( $address->toArray() )->toMatchArray( [
            'city'        => 'Austin',
            'postal_code' => '73301',
            'country'     => 'US',
        ] );
} );

it( 'accepts camelCase postalCode', function (): void {
    $address = Address::fromArray( [
        'name'       => 'Buyer',
        'line1'      => '1 Main',
        'city'       => 'Austin',
        'country'    => 'US',
        'postalCode' => '73301',
    ] );

    expect( $address->postalCode )->toBe( '73301' );
} );
