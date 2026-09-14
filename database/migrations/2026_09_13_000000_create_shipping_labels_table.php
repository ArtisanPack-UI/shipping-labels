<?php

/**
 * Create the shipping_labels table.
 *
 * @package    ArtisanPack_UI
 * @subpackage ShippingLabels
 *
 * @since      1.0.0
 */

declare( strict_types=1 );

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create( 'shipping_labels', function ( Blueprint $table ): void {
            $table->id();
            $table->string( 'provider_key', 120 );
            $table->string( 'status', 40 )->default( 'purchased' );
            $table->string( 'carrier', 120 )->nullable();
            $table->string( 'service', 120 )->nullable();
            $table->string( 'tracking_number', 255 )->nullable();
            $table->string( 'tracking_url', 500 )->nullable();
            $table->string( 'label_url', 500 )->nullable();
            $table->string( 'label_format', 20 )->nullable();
            $table->unsignedBigInteger( 'cost_amount' )->nullable();
            $table->char( 'cost_currency', 3 )->nullable();
            $table->json( 'from_address' )->nullable();
            $table->json( 'to_address' )->nullable();
            $table->json( 'parcel' )->nullable();
            $table->json( 'meta' )->nullable();
            $table->string( 'external_id', 255 )->nullable();
            $table->timestamp( 'purchased_at' )->nullable();
            $table->timestamp( 'voided_at' )->nullable();
            $table->timestamps();

            $table->index( [ 'provider_key', 'external_id' ], 'shipping_labels_provider_external_idx' );
            $table->index( 'tracking_number', 'shipping_labels_tracking_idx' );
            $table->index( 'status', 'shipping_labels_status_idx' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists( 'shipping_labels' );
    }
};
