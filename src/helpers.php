<?php

/**
 * Package helper functions.
 *
 * This file contains global helper functions for the package.
 * Add your custom helper functions below.
 *
 * @package    ArtisanPack_UI
 * @subpackage PackageBlueprint
 *
 * @since      1.0.0
 */

use ArtisanPackUI\PackageBlueprint\Package;

if ( ! function_exists( 'package' ) ) {
    /**
     * Get the Package instance.
     *
     * @since 1.0.0
     *
     * @return Package
     */
    function package(): Package
    {
        return app( 'package' );
    }
}

// Add your custom helper functions below
