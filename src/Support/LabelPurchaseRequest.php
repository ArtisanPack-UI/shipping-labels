<?php

/**
 * Label purchase request DTO.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\ShippingLabels\Support;

/**
 * Immutable value object describing the input passed to a LabelProvider
 * when buying a shipping label.
 *
 * Downstream packages (ecommerce, WMS, etc.) translate their own domain
 * objects (Shipment, Order, …) into a LabelPurchaseRequest before calling
 * into a driver, so the shipping-labels package stays domain-agnostic.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */
final class LabelPurchaseRequest
{
    /**
     * @since 1.0.0
     *
     * @param  Address              $from      Sender address.
     * @param  Address              $to        Recipient address.
     * @param  Parcel               $parcel    Parcel details.
     * @param  string|null          $service   Optional carrier-specific service key (e.g. 'usps_priority').
     * @param  string|null          $reference Optional external reference (order number, shipment id).
     * @param  array<string, mixed> $meta      Optional provider-specific metadata.
     */
    public function __construct(
        public readonly Address $from,
        public readonly Address $to,
        public readonly Parcel $parcel,
        public readonly ?string $service = null,
        public readonly ?string $reference = null,
        public readonly array $meta = [],
    ) {
    }
}
