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

    protected $vite = [
        'input' => [
            'resources/js/color-swatches.js',
            'resources/css/color-swatches.css',
        ],
        'publicDirectory' => 'dist',
        'hotFile' => __DIR__.'/../dist/hot',
    ];

    public function bootAddon()
    {
        GraphQL::addType(ColorSwatchType::class);
    }
}
