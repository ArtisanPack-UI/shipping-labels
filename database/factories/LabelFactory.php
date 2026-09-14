<?php

/**
 * Factory for the Label model.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\ShippingLabels\Database\Factories;

use ArtisanPackUI\ShippingLabels\Models\Label;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Label>
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */
class LabelFactory extends Factory
{
    /**
     * @var class-string<Label>
     */
    protected $model = Label::class;

    /**
     * Define the model's default state.
     *
     * @since 1.0.0
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider_key'    => 'null',
            'status'          => Label::STATUS_PURCHASED,
            'carrier'         => 'null-carrier',
            'service'         => 'ground',
            'tracking_number' => strtoupper( $this->faker->bothify( '1Z####??????????' ) ),
            'tracking_url'    => 'https://example.test/track/' . $this->faker->uuid(),
            'label_url'       => 'https://example.test/labels/' . $this->faker->uuid() . '.pdf',
            'label_format'    => 'pdf',
            'cost_amount'     => $this->faker->numberBetween( 500, 5000 ),
            'cost_currency'   => 'USD',
            'from_address'    => [
                'name'        => $this->faker->company(),
                'line1'       => $this->faker->streetAddress(),
                'city'        => $this->faker->city(),
                'region'      => $this->faker->stateAbbr(),
                'postal_code' => $this->faker->postcode(),
                'country'     => 'US',
            ],
            'to_address' => [
                'name'        => $this->faker->name(),
                'line1'       => $this->faker->streetAddress(),
                'city'        => $this->faker->city(),
                'region'      => $this->faker->stateAbbr(),
                'postal_code' => $this->faker->postcode(),
                'country'     => 'US',
            ],
            'parcel' => [
                'weight_grams' => 500,
                'length_mm'    => 200,
                'width_mm'     => 150,
                'height_mm'    => 100,
            ],
            'meta'         => [],
            'external_id'  => $this->faker->uuid(),
            'purchased_at' => now(),
            'voided_at'    => null,
        ];
    }

    /**
     * State: voided label.
     *
     * @since 1.0.0
     *
     * @return self
     */
    public function voided(): self
    {
        return $this->state( fn () => [
            'status'    => Label::STATUS_VOIDED,
            'voided_at' => now(),
        ] );
    }

    /**
     * State: failed label.
     *
     * @since 1.0.0
     *
     * @return self
     */
    public function failed(): self
    {
        return $this->state( fn () => [
            'status'          => Label::STATUS_FAILED,
            'tracking_number' => null,
            'label_url'       => null,
        ] );
    }
}
