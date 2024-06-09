<?php

namespace Kraenkvisuell\DiscountCodes\Tests;

use Kraenkvisuell\DiscountCodes\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
