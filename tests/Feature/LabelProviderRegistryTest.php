<?php

declare( strict_types=1 );

use ArtisanPackUI\ShippingLabels\Providers\NullLabelProvider;
use ArtisanPackUI\ShippingLabels\Registries\LabelProviderRegistry;

it( 'resolves the registry from the container as a singleton', function (): void {
    $a = app( LabelProviderRegistry::class );
    $b = app( LabelProviderRegistry::class );

    expect( $a )->toBeInstanceOf( LabelProviderRegistry::class )
        ->and( $b )->toBe( $a );
} );

it( 'registers a provider and looks it up by key', function (): void {
    $registry = app( LabelProviderRegistry::class );
    $provider = new NullLabelProvider();

    $registry->register( $provider );

    expect( $registry->has( 'null' ) )->toBeTrue()
        ->and( $registry->get( 'null' ) )->toBe( $provider )
        ->and( $registry->keys() )->toContain( 'null' );
} );

it( 'throws when getting an unknown key', function (): void {
    app( LabelProviderRegistry::class )->get( 'does-not-exist' );
} )->throws( InvalidArgumentException::class );

it( 'forgets a registered provider', function (): void {
    $registry = app( LabelProviderRegistry::class );
    $registry->register( new NullLabelProvider() );

    $registry->forget( 'null' );

    expect( $registry->has( 'null' ) )->toBeFalse();
} );

it( 'exposes the shipping_labels() helper', function (): void {
    expect( shipping_labels() )->toBe( app( LabelProviderRegistry::class ) );
} );
