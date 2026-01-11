<?php

/**
 * Package service provider.
 *
 * Bootstraps the Package by registering services and bindings.
 *
 * @package    ArtisanPack_UI
 * @subpackage PackageBlueprint
 *
 * @author     Jacob Martella <me@jacobmartella.com>
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\PackageBlueprint;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider for the Package.
 *
 * Bootstraps the Package by registering services and bindings.
 * Extend this class with your package's configuration, migrations,
 * routes, views, and other service registrations.
 *
 * @package    ArtisanPack_UI
 * @subpackage PackageBlueprint
 *
 * @since      1.0.0
 */
class PackageServiceProvider extends ServiceProvider
{
    /**
     * Registers any application services.
     *
     * Binds the Package class as a singleton in the container.
     * Add additional service registrations here.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton( 'package', function ( $app ) {
            return new Package();
        } );
    }

    /**
     * Bootstraps any application services.
     *
     * Add package bootstrapping here such as:
     * - Configuration publishing: $this->publishes([...])
     * - Migration loading: $this->loadMigrationsFrom(...)
     * - View loading: $this->loadViewsFrom(...)
     * - Route loading: $this->loadRoutesFrom(...)
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function boot(): void
    {
        // Add your package bootstrapping here
    }
}
