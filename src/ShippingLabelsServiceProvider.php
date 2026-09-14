<?php

/**
 * Shipping Labels service provider.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @author     Jacob Martella <me@jacobmartella.com>
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\ShippingLabels;

use ArtisanPackUI\ShippingLabels\Registries\LabelProviderRegistry;
use Illuminate\Support\ServiceProvider;

/**
 * Registers the LabelProviderRegistry and loads the package migrations.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */
class ShippingLabelsServiceProvider extends ServiceProvider
{
    /**
     * Register bindings.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton( LabelProviderRegistry::class, function (): LabelProviderRegistry {
            return new LabelProviderRegistry();
        } );

        $this->app->alias( LabelProviderRegistry::class, 'shipping-labels.registry' );
    }

    /**
     * Bootstrap package services.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom( __DIR__ . '/../database/migrations' );

        if ( $this->app->runningInConsole() ) {
            $this->publishes( [
                __DIR__ . '/../database/migrations' => database_path( 'migrations' ),
            ], 'shipping-labels-migrations' );
        }
    }
}
