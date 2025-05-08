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
                'type' => Type::string(),
                'description' => 'Color value',
                'resolve' => function ($values, array $args) {
                    if (is_string($values['value'])) {
                        return $values['value'];
                    }

                    return Arr::first($values['value']);
                }
            ],
        ];
    }
}
