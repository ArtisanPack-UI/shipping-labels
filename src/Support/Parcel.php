<?php

/**
 * Parcel DTO for shipping labels.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\ShippingLabels\Support;

/**
 * Immutable value object describing the physical parcel being shipped.
 *
 * All dimensions are stored in millimetres and weight in grams so that
 * providers can convert to their preferred unit system without ambiguity.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */
final class Parcel
{
    /**
     * @since 1.0.0
     *
     * @param  int   $weightGrams  Weight in grams.
     * @param  int   $lengthMm     Length in millimetres.
     * @param  int   $widthMm      Width in millimetres.
     * @param  int   $heightMm     Height in millimetres.
     * @param  int   $valueMinor   Declared value in minor currency units.
     * @param  string $valueCurrency ISO 4217 currency code for the declared value.
     */
    public function __construct(
        public readonly int $weightGrams,
        public readonly int $lengthMm,
        public readonly int $widthMm,
        public readonly int $heightMm,
        public readonly int $valueMinor = 0,
        public readonly string $valueCurrency = 'USD',
    ) {
    }

    /**
     * Convert to an array suitable for JSON persistence.
     *
     * @since 1.0.0
     *
     * @return array<string, int|string>
     */
    public function toArray(): array
    {
        return [
            'weight_grams'   => $this->weightGrams,
            'length_mm'      => $this->lengthMm,
            'width_mm'       => $this->widthMm,
            'height_mm'      => $this->heightMm,
            'value_minor'    => $this->valueMinor,
            'value_currency' => $this->valueCurrency,
        ];
    }
}
