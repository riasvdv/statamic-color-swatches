<?php

namespace Rias\ColorSwatches;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $fieldtypes = [
        ColorSwatchesFieldtype::class,
    ];

    protected $stylesheets = [
        __DIR__.'/../dist/css/color-swatches.css',
    ];

    protected $scripts = [
        __DIR__.'/../dist/js/color-swatches.js',
    ];
}
