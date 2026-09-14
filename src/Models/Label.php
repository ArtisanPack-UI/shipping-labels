<?php

/**
 * Label Eloquent model.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

namespace ArtisanPackUI\ShippingLabels\Models;

use ArtisanPackUI\ShippingLabels\Database\Factories\LabelFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Persistent record of a shipping label.
 *
 * A Label row is written by a LabelProvider driver after the carrier
 * successfully issues a label. Consumers persist the primary key on their
 * own domain rows (e.g. an ecommerce `shipments.label_id` soft FK) rather
 * than a hard foreign key so the shipping-labels package stays optional.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 *
 * @property int                        $id
 * @property string                     $provider_key
 * @property string                     $status
 * @property string|null                $carrier
 * @property string|null                $service
 * @property string|null                $tracking_number
 * @property string|null                $tracking_url
 * @property string|null                $label_url
 * @property string|null                $label_format
 * @property int|null                   $cost_amount
 * @property string|null                $cost_currency
 * @property array<string, mixed>|null  $from_address
 * @property array<string, mixed>|null  $to_address
 * @property array<string, mixed>|null  $parcel
 * @property array<string, mixed>       $meta
 * @property string|null                $external_id
 * @property \Illuminate\Support\Carbon|null $purchased_at
 * @property \Illuminate\Support\Carbon|null $voided_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Label extends Model
{
    use HasFactory;

    public const STATUS_PURCHASED = 'purchased';
    public const STATUS_VOIDED    = 'voided';
    public const STATUS_FAILED    = 'failed';

    /**
     * The database table name.
     *
     * @var string
     */
    protected $table = 'shipping_labels';

    /**
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * Declared as a property (not a `casts()` method) so the casts still
     * apply on Laravel 10, where the method-based API does not exist.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'from_address' => 'array',
        'to_address'   => 'array',
        'parcel'       => 'array',
        'meta'         => 'array',
        'cost_amount'  => 'integer',
        'purchased_at' => 'datetime',
        'voided_at'    => 'datetime',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @since 1.0.0
     *
     * @return Factory<Label>
     */
    protected static function newFactory(): Factory
    {
        return LabelFactory::new();
    }
}
