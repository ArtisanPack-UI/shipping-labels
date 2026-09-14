<?php

/**
 * Address DTO for shipping labels.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\ShippingLabels\Support;

/**
 * Immutable value object describing a shipping address.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */
final class Address
{
    /**
     * @since 1.0.0
     *
     * @param  string       $name         Recipient/sender name.
     * @param  string       $line1        Street line 1.
     * @param  string       $city         City.
     * @param  string       $postalCode   Postal/ZIP code.
     * @param  string       $country      ISO 3166-1 alpha-2 country code.
     * @param  string|null  $line2        Optional street line 2.
     * @param  string|null  $region       State/province/region code.
     * @param  string|null  $company      Optional company name.
     * @param  string|null  $phone        Optional phone number.
     * @param  string|null  $email        Optional email address.
     */
    public function __construct(
        public readonly string $name,
        public readonly string $line1,
        public readonly string $city,
        public readonly string $postalCode,
        public readonly string $country,
        public readonly ?string $line2 = null,
        public readonly ?string $region = null,
        public readonly ?string $company = null,
        public readonly ?string $phone = null,
        public readonly ?string $email = null,
    ) {
    }

    /**
     * Build an Address from an associative array.
     *
     * @since 1.0.0
     *
     * @param  array<string, mixed>  $data  Address data.
     *
     * @return self
     */
    public static function fromArray( array $data ): self
    {
        return new self(
            name:       (string) ( $data['name'] ?? '' ),
            line1:      (string) ( $data['line1'] ?? '' ),
            city:       (string) ( $data['city'] ?? '' ),
            postalCode: (string) ( $data['postal_code'] ?? $data['postalCode'] ?? '' ),
            country:    (string) ( $data['country'] ?? '' ),
            line2:      isset( $data['line2'] ) ? (string) $data['line2']   : null,
            region:     isset( $data['region'] ) ? (string) $data['region']  : null,
            company:    isset( $data['company'] ) ? (string) $data['company'] : null,
            phone:      isset( $data['phone'] ) ? (string) $data['phone']   : null,
            email:      isset( $data['email'] ) ? (string) $data['email']   : null,
        );
    }

    /**
     * Convert the address to a persistence-friendly array.
     *
     * @since 1.0.0
     *
     * @return array<string, string|null>
     */
    public function toArray(): array
    {
        return [
            'name'        => $this->name,
            'line1'       => $this->line1,
            'line2'       => $this->line2,
            'city'        => $this->city,
            'region'      => $this->region,
            'postal_code' => $this->postalCode,
            'country'     => $this->country,
            'company'     => $this->company,
            'phone'       => $this->phone,
            'email'       => $this->email,
        ];
    }
}
