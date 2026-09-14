<?php

/**
 * Tracking status DTO returned by LabelProvider::trackLabel().
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\ShippingLabels\Support;

use Carbon\CarbonInterface;

/**
 * Immutable value object describing the current carrier tracking status
 * of a label.
 *
 * Providers normalise their carrier-specific status strings into the
 * `code` enumeration below so consumers can branch on a stable vocabulary.
 * The raw carrier payload is preserved on `raw` for logging/debugging.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */
final class TrackingStatus
{
    public const CODE_PENDING          = 'pending';
    public const CODE_IN_TRANSIT       = 'in_transit';
    public const CODE_OUT_FOR_DELIVERY = 'out_for_delivery';
    public const CODE_DELIVERED        = 'delivered';
    public const CODE_EXCEPTION        = 'exception';
    public const CODE_RETURNED         = 'returned';
    public const CODE_UNKNOWN          = 'unknown';

    /**
     * @since 1.0.0
     *
     * @param  string                    $code        Normalised status code (see CODE_* constants).
     * @param  string|null               $description Optional human-readable description.
     * @param  string|null               $location   Optional last-known location.
     * @param  CarbonInterface|null      $occurredAt When the status was observed.
     * @param  array<string, mixed>      $raw         Provider-native payload for debugging.
     */
    public function __construct(
        public readonly string $code,
        public readonly ?string $description = null,
        public readonly ?string $location = null,
        public readonly ?CarbonInterface $occurredAt = null,
        public readonly array $raw = [],
    ) {
    }

    /**
     * Is the shipment considered delivered?
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function isDelivered(): bool
    {
        return self::CODE_DELIVERED === $this->code;
    }

    /**
     * Is the shipment in an error state?
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function isException(): bool
    {
        return self::CODE_EXCEPTION === $this->code;
    }
}
