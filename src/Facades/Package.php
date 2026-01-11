<?php

/**
 * Package Facade.
 *
 * Provides static access to the Package class.
 *
 * @package    ArtisanPack_UI
 * @subpackage PackageBlueprint
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\PackageBlueprint\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Package Facade.
 *
 * @see \ArtisanPackUI\PackageBlueprint\Package
 *
 * @package    ArtisanPack_UI
 * @subpackage PackageBlueprint
 *
 * @since      1.0.0
 */
class Package extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @since 1.0.0
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'package';
    }
}
