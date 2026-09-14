<?php

/**
 * Shipping Labels helper functions.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

use ArtisanPackUI\ShippingLabels\Registries\LabelProviderRegistry;

if ( ! function_exists( 'shipping_labels' ) ) {
    /**
     * Resolve the LabelProviderRegistry from the container.
     *
     * @since 1.0.0
     *
     * @return LabelProviderRegistry
     */
    function shipping_labels(): LabelProviderRegistry
    {
        return app( LabelProviderRegistry::class );
    }
}
