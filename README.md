![Icon](https://github.com/riasvdv/statamic-color-swatches/raw/main/icon.svg)

[![Latest Version](https://img.shields.io/github/release/riasvdv/statamic-color-swatches.svg?style=flat-square)](https://github.com/riasvdv/statamic-color-swatches/releases)

# Color Swatches

> Color Swatches for Statamic >= v3.

For the Statamic 2 version, check out the [v1 branch](https://github.com/riasvdv/statamic-color-swatches/tree/v1)

Let clients choose from a predefined set of colors.

![Screenshot](https://github.com/riasvdv/statamic-color-swatches/raw/main/docs/img/color-swatches-screenshot.png)

## License

Color Swatches requires a license to be used while on a production site.  
You can purchase one at https://statamic.com/marketplace/addons/color-swatches.

You may use Color Swatches without a license while Statamic is in [Trial mode](https://statamic.dev/tips/how-to-enable-statamic-pro#trial-mode).

## Installation

Require it using Composer.

```
composer require rias/statamic-color-swatches
```

Publish the assets:

```
php artisan vendor:publish --provider="Rias\ColorSwatches\ServiceProvider"
```

## Color Swatches Overview

Instead of providing a user a full color picker, Color Swatches gives an admin the ability to provide a selection of colors for a user to choose from.

## Using Color Swatches

Add the fieldtype to your fieldset, you can define multiple colors for a swatch by using a YAML array. You can also set a default color by entering the label.

```yaml
sections:
  main:
    display: Main
    fields:
      -
        handle: color
        field:
          type: color_swatches
          display: Color
          colors:
            -
              label: red
              value:
                - '#F56565'
            -
              label: orange
              value:
                - '#ED8936'
            -
              label: green
              value:
                - '#48BB78'
            -
              label: blue_yellow
              value:
                - '#4299E1'
                - '#E7C961'
```

## Using Color Swatches

You can access both the label and color in your template.

```twig
{{ color.label }}
{{ color.value }}
{{ color.value.0 }} #If it's more than one color
```

Brought to you by [Rias](https://rias.be)
