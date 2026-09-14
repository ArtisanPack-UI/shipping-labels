<?php

/**
 * Shared contract test case for LabelProvider implementations.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\ShippingLabels\Testing;

use ArtisanPackUI\ShippingLabels\Contracts\LabelProvider;
use ArtisanPackUI\ShippingLabels\Models\Label;
use ArtisanPackUI\ShippingLabels\ShippingLabelsServiceProvider;
use ArtisanPackUI\ShippingLabels\Support\Address;
use ArtisanPackUI\ShippingLabels\Support\LabelPurchaseRequest;
use ArtisanPackUI\ShippingLabels\Support\Parcel;
use ArtisanPackUI\ShippingLabels\Support\TrackingStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;

/**
 * Abstract test case that satellite packages extend to prove their
 * driver honours the LabelProvider contract.
 *
 * Usage in a satellite:
 *
 * ```php
 * final class ShippoProviderContractTest extends LabelProviderContractTestCase
 * {
 *     protected function provider(): LabelProvider
 *     {
 *         return new ShippoLabelProvider( $this->fakeShippoClient() );
 *     }
 * }
 * ```
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */
abstract class LabelProviderContractTestCase extends TestCase
{
    use RefreshDatabase;

    public function test_key_returns_a_non_empty_string(): void
    {
        $key = $this->provider()->key();

        $this->assertIsString( $key );
        $this->assertNotSame( '', trim( $key ) );
    }

    public function test_buy_label_persists_and_returns_a_label_model(): void
    {
        $label = $this->provider()->buyLabel( $this->samplePurchaseRequest() );

        $this->assertInstanceOf( Label::class, $label );
        $this->assertTrue( $label->exists );
        $this->assertSame( Label::STATUS_PURCHASED, $label->status );
        $this->assertSame( $this->provider()->key(), $label->provider_key );
    }

    public function test_void_label_marks_the_label_as_voided(): void
    {
        $label = $this->provider()->buyLabel( $this->samplePurchaseRequest() );

        $this->provider()->voidLabel( $label );
        $label->refresh();

        $this->assertSame( Label::STATUS_VOIDED, $label->status );
        $this->assertNotNull( $label->voided_at );
    }

    public function test_track_label_returns_a_tracking_status(): void
    {
        $label = $this->provider()->buyLabel( $this->samplePurchaseRequest() );

        $status = $this->provider()->trackLabel( $label );

        $this->assertInstanceOf( TrackingStatus::class, $status );
        $this->assertIsString( $status->code );
        $this->assertNotSame( '', trim( $status->code ) );
    }

    /**
     * The driver under test. Subclasses return a configured instance.
     *
     * @since 1.0.0
     *
     * @return LabelProvider
     */
    abstract protected function provider(): LabelProvider;

    /**
     * @since 1.0.0
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array<int, class-string>
     */
    protected function getPackageProviders( $app ): array
    {
        return [
            ShippingLabelsServiceProvider::class,
        ];
    }

    /**
     * @since 1.0.0
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function defineEnvironment( $app ): void
    {
        $app['config']->set( 'database.default', 'testbench' );
        $app['config']->set( 'database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ] );
    }

    /**
     * Build a purchase request suitable for the driver under test.
     * Subclasses may override to inject carrier-specific fields.
     *
     * @since 1.0.0
     *
     * @return LabelPurchaseRequest
     */
    protected function samplePurchaseRequest(): LabelPurchaseRequest
    {
        return new LabelPurchaseRequest(
            from: new Address(
                name:       'Shipper Inc',
                line1:      '123 Sender St',
                city:       'Portland',
                postalCode: '97201',
                country:    'US',
                region:     'OR',
            ),
            to: new Address(
                name:       'Buyer Person',
                line1:      '456 Receiver Ave',
                city:       'Austin',
                postalCode: '73301',
                country:    'US',
                region:     'TX',
            ),
            parcel: new Parcel(
                weightGrams: 500,
                lengthMm:    200,
                widthMm:     150,
                heightMm:    100,
            ),
            service:   'ground',
            reference: 'test-shipment-1',
        );
    }
}
