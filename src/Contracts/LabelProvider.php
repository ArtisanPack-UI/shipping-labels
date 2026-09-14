<?php

/**
 * LabelProvider contract.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\ShippingLabels\Contracts;

use ArtisanPackUI\ShippingLabels\Models\Label;
use ArtisanPackUI\ShippingLabels\Support\LabelPurchaseRequest;
use ArtisanPackUI\ShippingLabels\Support\TrackingStatus;

/**
 * Carrier driver contract.
 *
 * Every carrier satellite (Shippo, EasyPost, USPS, ShipStation, …) implements
 * this contract and registers an instance with the LabelProviderRegistry.
 *
 * Contract:
 * - `key()` returns a stable, registry-safe identifier (kebab-case, e.g. `shippo`).
 * - `buyLabel()` MUST persist a Label row and return the stored model.
 * - `voidLabel()` MUST update the label's status to `voided` when the carrier
 *   confirms the void; it MAY throw if the carrier refuses.
 * - `trackLabel()` MUST return a normalised TrackingStatus. Providers that
 *   cannot determine a status yet should return one with
 *   {@see TrackingStatus::CODE_PENDING}.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */
interface LabelProvider
{
    /**
     * Stable, registry-safe identifier for this driver.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function key(): string;

    /**
     * Purchase a shipping label from the carrier and persist it.
     *
     * @since 1.0.0
     *
     * @param  LabelPurchaseRequest  $request  The label purchase request.
     *
     * @return Label The persisted Label model.
     */
    public function buyLabel( LabelPurchaseRequest $request ): Label;

    /**
     * Void a previously purchased label.
     *
     * Implementations MUST mark the label as voided when the carrier
     * confirms the void. If the carrier refuses the void (label already
     * scanned, past window, etc.) the implementation MAY throw.
     *
     * @since 1.0.0
     *
     * @param  Label  $label  The label to void.
     *
     * @return void
     */
    public function voidLabel( Label $label ): void;

    /**
     * Fetch the current tracking status for a label.
     *
     * @since 1.0.0
     *
     * @param  Label  $label  The label to track.
     *
     * @return TrackingStatus The normalised tracking status.
     */
    public function trackLabel( Label $label ): TrackingStatus;
}
