<?php

/**
 * NullLabelProvider.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\ShippingLabels\Providers;

use ArtisanPackUI\ShippingLabels\Contracts\LabelProvider;
use ArtisanPackUI\ShippingLabels\Models\Label;
use ArtisanPackUI\ShippingLabels\Support\LabelPurchaseRequest;
use ArtisanPackUI\ShippingLabels\Support\TrackingStatus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * No-op carrier driver used in tests, local development, and the
 * satellite contract test suite.
 *
 * Every call succeeds and persists a real Label row so consumers can
 * exercise their own code without hitting a live carrier API.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */
class NullLabelProvider implements LabelProvider
{
    /**
     * @since 1.0.0
     *
     * @param  string  $key  Override the registry key (default: `null`).
     */
    public function __construct( protected string $key = 'null' )
    {
    }

    /**
     * @inheritDoc
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function buyLabel( LabelPurchaseRequest $request ): Label
    {
        $trackingNumber = 'NULL-' . strtoupper( Str::random( 12 ) );

        return Label::create( [
            'provider_key'    => $this->key(),
            'status'          => Label::STATUS_PURCHASED,
            'carrier'         => 'null-carrier',
            'service'         => $request->service ?? 'ground',
            'tracking_number' => $trackingNumber,
            'tracking_url'    => 'https://example.test/track/' . $trackingNumber,
            'label_url'       => 'https://example.test/labels/' . $trackingNumber . '.pdf',
            'label_format'    => 'pdf',
            'cost_amount'     => 0,
            'cost_currency'   => $request->parcel->valueCurrency,
            'from_address'    => $request->from->toArray(),
            'to_address'      => $request->to->toArray(),
            'parcel'          => $request->parcel->toArray(),
            'meta'            => $request->meta,
            'external_id'     => $request->reference,
            'purchased_at'    => Carbon::now(),
        ] );
    }

    /**
     * @inheritDoc
     */
    public function voidLabel( Label $label ): void
    {
        $label->forceFill( [
            'status'    => Label::STATUS_VOIDED,
            'voided_at' => Carbon::now(),
        ] )->save();
    }

    /**
     * @inheritDoc
     */
    public function trackLabel( Label $label ): TrackingStatus
    {
        $code = Label::STATUS_VOIDED === $label->status
            ? TrackingStatus::CODE_EXCEPTION
            : TrackingStatus::CODE_PENDING;

        return new TrackingStatus(
            code:        $code,
            description: 'Null provider — no real carrier lookup performed.',
            occurredAt:  Carbon::now(),
        );
    }
}
