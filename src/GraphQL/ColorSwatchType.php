<?php

namespace Rias\ColorSwatches\GraphQL;

use GraphQL\Type\Definition\Type;

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
                'type' => Type::string(),
                'description' => 'Color value',
                'resolve' => function ($values, array $args) {
                    return array_first($values['value']);
                }
            ],
        ];
    }
}