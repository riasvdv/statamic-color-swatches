<?php

namespace Rias\ColorSwatches;

use Rias\ColorSwatches\GraphQL\ColorSwatchType;
use Statamic\Facades\GraphQL;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $fieldtypes = [
        ColorSwatchesFieldtype::class,
    ];

    public function bootAddon()
    {
        GraphQL::addType(ColorSwatchType::class);
    }

    protected $stylesheets = [
        __DIR__.'/../dist/css/color-swatches.css',
    ];

    protected $scripts = [
        __DIR__.'/../dist/js/color-swatches.js',
    ];
}
