<?php

namespace Rias\ColorSwatches;

use Statamic\Fields\Fieldtype;
use Statamic\Facades\GraphQL;

class ColorSwatchesFieldtype extends Fieldtype
{
    protected $configFields = [
        'colors' => [
            'type'         => 'grid',
            'display' => 'Colors',
            'instructions' => 'Define the colors that can be selected.',
            'add_row'      => 'Add color',
            'mode' => 'stacked',
            'fields'       => [
                [
                    'handle' => 'label',
                    'field'  => [
                        'type' => 'text',
                        'display' => 'Label',
                        'instructions' => 'The label of the color. This can also be the class you use in your CSS for example.',
                        'width' => 100,
                    ],
                ],
                [
                    'handle'  => 'value',
                    'field'   => [
                        'type' => 'list',
                        'display' => 'Values',
                        'instructions' => 'One or more CSS color values.',
                        'width' => 100,
                    ],
                ],
            ],
        ],
        'default' => [
            'type'         => 'text',
            'instructions' => 'The label of the default color.',
        ],
        'allow_blank' => [
            'type'         => 'toggle',
            'display'      => 'Allow Blank',
            'instructions' => 'Allow deselecting the color, showing a "None" option.',
            'default'      => false,
        ],
        'max_items' => [
            'type'         => 'integer',
            'display'      => 'Max Items',
            'instructions' => 'The maximum number of swatches that can be selected. Set to 1 for single select mode.',
            'default'      => 1,
        ],
        'min_items' => [
            'type'         => 'integer',
            'display'      => 'Min Items',
            'instructions' => 'The minimum number of swatches that must be selected. Only applies when Max Items is not 1.',
            'default'      => 0,
        ],
        'show_labels' => [
            'type'         => 'toggle',
            'display'      => 'Show Labels',
            'instructions' => 'Display the color label below each swatch.',
            'default'      => false,
        ],
        'swatch_size' => [
            'type'         => 'button_group',
            'display'      => 'Swatch Size',
            'instructions' => 'The size of each color swatch.',
            'default'      => 'medium',
            'options'      => [
                'small'  => 'Small',
                'medium' => 'Medium',
                'large'  => 'Large',
            ],
        ],
        'columns' => [
            'type'         => 'button_group',
            'display'      => 'Columns',
            'instructions' => 'Number of columns in the swatch grid. Auto will wrap naturally.',
            'default'      => 'auto',
            'options'      => [
                'auto' => 'Auto',
                '2'    => '2',
                '3'    => '3',
                '4'    => '4',
                '5'    => '5',
                '6'    => '6',
            ],
        ],
    ];

    public function icon(): string
    {
        return 'fieldtype-color';
    }

    public function rules(): array
    {
        if (! $this->isMultiSelect()) {
            return [];
        }

        $rules = ['array'];

        $minItems = $this->config('min_items') ?? 0;
        $maxItems = $this->config('max_items') ?? 0;

        if ($minItems > 0) {
            $rules[] = 'min:'.$minItems;
        }

        if ($maxItems > 0) {
            $rules[] = 'max:'.$maxItems;
        }

        return $rules;
    }

    public function process($data): mixed
    {
        if ($this->isMultiSelect()) {
            return collect($data)->map(function ($item) {
                return $this->processItem($item);
            })->all();
        }

        return $this->processItem($data);
    }

    public function augment($value): mixed
    {
        return $value;
    }

    public function toGqlType(): mixed
    {
        if ($this->isMultiSelect()) {
            return GraphQL::listOf(GraphQL::type('ColorSwatchType'));
        }

        return GraphQL::type('ColorSwatchType');
    }

    private function processItem(mixed $data): mixed
    {
        if (isset($data['value']) && is_string($data['value'])) {
            $data['value'] = explode(',', $data['value']);
        }

        return $data;
    }

    private function isMultiSelect(): bool
    {
        return ($this->config('max_items') ?? 1) !== 1;
    }
}
