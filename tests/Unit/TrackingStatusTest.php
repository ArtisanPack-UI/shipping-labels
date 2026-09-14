<?php

declare( strict_types=1 );

use ArtisanPackUI\ShippingLabels\Support\TrackingStatus;

it( 'reports delivered', function (): void {
    $status = new TrackingStatus( TrackingStatus::CODE_DELIVERED );

    expect( $status->isDelivered() )->toBeTrue()
        ->and( $status->isException() )->toBeFalse();
} );

it( 'reports exception', function (): void {
    $status = new TrackingStatus( TrackingStatus::CODE_EXCEPTION );

    expect( $status->isException() )->toBeTrue()
        ->and( $status->isDelivered() )->toBeFalse();
} );
