<?php

namespace Rias\ColorSwatches;

use Statamic\Fields\Fieldtype;
use Statamic\Facades\GraphQL;

class ColorSwatchesFieldtype extends Fieldtype
{
    protected $configFields = [
        'colors' => [
            'type'         => 'grid',
            'instructions' => 'Define the colors that can be selected.',
            'add_row'      => 'Add color',
            'fields'       => [
                'label' => [
                    'handle' => 'label',
                    'field'  => [
                        'type' => 'text',
                    ],
                ],
                'value' => [
                    'display' => 'Values',
                    'handle'  => 'value',
                    'field'   => [
                        'type' => 'list',
                    ],
                ],
            ],
        ],
        'default' => [
            'type'         => 'text',
            'instructions' => 'The label of the default color.',
        ],
    ];

    public function icon()
    {
        return 'color';
    }

    public function process($data)
    {
        if (isset($data['value']) && is_string($data['value'])) {
            $data['value'] = explode(',', $data['value']);
        }

        return $data;
    }

    public function augment($value)
    {
        return $value;
    }

    public function toGqlType()
    {
        return GraphQL::type('ColorSwatchType');
    }
}
