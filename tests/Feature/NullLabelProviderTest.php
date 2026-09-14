<?php

declare( strict_types=1 );

use ArtisanPackUI\ShippingLabels\Models\Label;
use ArtisanPackUI\ShippingLabels\Providers\NullLabelProvider;
use ArtisanPackUI\ShippingLabels\Support\Address;
use ArtisanPackUI\ShippingLabels\Support\LabelPurchaseRequest;
use ArtisanPackUI\ShippingLabels\Support\Parcel;
use ArtisanPackUI\ShippingLabels\Support\TrackingStatus;

function buildPurchaseRequest(): LabelPurchaseRequest
{
    return new LabelPurchaseRequest(
        from: new Address(
            name:       'Shipper Inc',
            line1:      '123 Sender St',
            city:       'Portland',
            postalCode: '97201',
            country:    'US',
            region:     'OR',
        ),
        to: new Address(
            name:       'Buyer Person',
            line1:      '456 Receiver Ave',
            city:       'Austin',
            postalCode: '73301',
            country:    'US',
            region:     'TX',
        ),
        parcel: new Parcel(
            weightGrams: 500,
            lengthMm:    200,
            widthMm:     150,
            heightMm:    100,
        ),
        service:   'ground',
        reference: 'test-shipment-1',
    );
}

it( 'buys a label and persists it', function (): void {
    $provider = new NullLabelProvider();

    $label = $provider->buyLabel( buildPurchaseRequest() );

    expect( $label )->toBeInstanceOf( Label::class )
        ->and( $label->exists )->toBeTrue()
        ->and( $label->status )->toBe( Label::STATUS_PURCHASED )
        ->and( $label->provider_key )->toBe( 'null' )
        ->and( $label->tracking_number )->toStartWith( 'NULL-' )
        ->and( $label->from_address )->toMatchArray( [ 'city' => 'Portland' ] )
        ->and( $label->parcel )->toMatchArray( [ 'weight_grams' => 500 ] );
} );

it( 'voids a purchased label', function (): void {
    $provider = new NullLabelProvider();
    $label    = $provider->buyLabel( buildPurchaseRequest() );

    $provider->voidLabel( $label );
    $label->refresh();

    expect( $label->status )->toBe( Label::STATUS_VOIDED )
        ->and( $label->voided_at )->not->toBeNull();
} );

it( 'returns a pending tracking status for a purchased label', function (): void {
    $provider = new NullLabelProvider();
    $label    = $provider->buyLabel( buildPurchaseRequest() );

    $status = $provider->trackLabel( $label );

    expect( $status )->toBeInstanceOf( TrackingStatus::class )
        ->and( $status->code )->toBe( TrackingStatus::CODE_PENDING );
} );

it( 'returns an exception tracking status for a voided label', function (): void {
    $provider = new NullLabelProvider();
    $label    = $provider->buyLabel( buildPurchaseRequest() );
    $provider->voidLabel( $label );

    $status = $provider->trackLabel( $label->fresh() );

    expect( $status->code )->toBe( TrackingStatus::CODE_EXCEPTION )
        ->and( $status->isException() )->toBeTrue();
} );

it( 'exposes a custom key when constructed with one', function (): void {
    $provider = new NullLabelProvider( 'sandbox' );

    expect( $provider->key() )->toBe( 'sandbox' );
} );
