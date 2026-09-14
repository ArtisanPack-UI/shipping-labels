<?php

/**
 * LabelProviderRegistry.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\ShippingLabels\Registries;

use ArtisanPackUI\ShippingLabels\Contracts\LabelProvider;
use InvalidArgumentException;

/**
 * In-memory registry of carrier label drivers keyed by their `key()`.
 *
 * Satellite packages call {@see self::register()} from their service
 * provider `boot()` to make themselves discoverable.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */
class LabelProviderRegistry
{
    /**
     * @var array<string, LabelProvider>
     */
    protected array $providers = [];

    /**
     * Register a driver. Later calls with the same key overwrite earlier ones
     * so satellites can decorate a built-in driver.
     *
     * @since 1.0.0
     *
     * @param  LabelProvider  $provider  The driver instance.
     *
     * @return void
     */
    public function register( LabelProvider $provider ): void
    {
        $this->providers[ $provider->key() ] = $provider;
    }

    /**
     * Get a driver by key.
     *
     * @since 1.0.0
     *
     * @param  string  $key  The driver key.
     *
     * @throws InvalidArgumentException When no driver is registered for the key.
     *
     * @return LabelProvider
     */
    public function get( string $key ): LabelProvider
    {
        if ( ! isset( $this->providers[ $key ] ) ) {
            throw new InvalidArgumentException(
                sprintf( 'No shipping label provider registered for key [%s].', $key ),
            );
        }

        return $this->providers[ $key ];
    }

    /**
     * Is a driver registered for this key?
     *
     * @since 1.0.0
     *
     * @param  string  $key  The driver key.
     *
     * @return bool
     */
    public function has( string $key ): bool
    {
        return isset( $this->providers[ $key ] );
    }

    /**
     * All registered drivers, keyed by their `key()`.
     *
     * @since 1.0.0
     *
     * @return array<string, LabelProvider>
     */
    public function all(): array
    {
        return $this->providers;
    }

    /**
     * All registered driver keys.
     *
     * @since 1.0.0
     *
     * @return list<string>
     */
    public function keys(): array
    {
        return array_keys( $this->providers );
    }

    /**
     * Remove a driver from the registry.
     *
     * @since 1.0.0
     *
     * @param  string  $key  The driver key.
     *
     * @return void
     */
    public function forget( string $key ): void
    {
        unset( $this->providers[ $key ] );
    }
}
