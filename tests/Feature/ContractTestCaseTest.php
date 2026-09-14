<?php

declare( strict_types=1 );

namespace Tests\Feature;

use ArtisanPackUI\ShippingLabels\Contracts\LabelProvider;
use ArtisanPackUI\ShippingLabels\Providers\NullLabelProvider;
use ArtisanPackUI\ShippingLabels\Testing\LabelProviderContractTestCase;

/**
 * Runs the published LabelProviderContractTestCase against the built-in
 * NullLabelProvider so we know the shared contract test class stays green
 * for any satellite that inherits it.
 */
final class ContractTestCaseTest extends LabelProviderContractTestCase
{
    protected function provider(): LabelProvider
    {
        return new NullLabelProvider();
    }
}
