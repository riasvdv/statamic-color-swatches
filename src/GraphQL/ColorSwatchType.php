<?php

namespace Rias\ColorSwatches\GraphQL;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\Arr;

class ColorSwatchType extends \Rebing\GraphQL\Support\Type
{
    protected $attributes = [
        'name' => 'ColorSwatchType',
        'description' => 'Type for Rias statamic color swatch',
    ];

    public function fields(): array
    {
        return [
            'label' => [
                'type' => Type::string(),
                'description' => 'Color label',
                'resolve' => function ($values, array $args) {
                    return $values['label'];
                }
            ],
            'value' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'Color values',
                'resolve' => function ($values, array $args) {
                    return Arr::wrap($values['value']);
                }
            ],
        ];
    }
}
