## dynamicColor

dynamicColor is a small class which is aimed at PHP developers needing color manipulation. It allows you to convert HEX colors to RGBA and manipulate them easily. I built this plugin specifically with WordPress themes in mind where you'd want to capture a color setting from the user and then manipulate it a but.

As such right now it only works with a HEX input and it always returns RGBA (to make sure we can manipulat opaciy). Due to the way we use colors we have provided three versions of each manipulation method.

## Available Manipulation Methods
- <strong>darken( [$amount] )</strong> : Returns a darker shade of your color.
- <strong>set_darken( [$amount] )</strong> : Sets a darker shade of your color.
- <strong>show_darken( [$amount] )</strong> : Echoes a darker shade of your color.
- <strong>lighten( [$amount] )</strong> : Returns a lighter shade of your color.
- <strong>set_lighten( [$amount] )</strong> : Sets a lighter shade of your color.
- <strong>show_lighten( [$amount] )</strong> : Echoes a lighter shade of your color.
- <strong>opacity( [$amount] )</strong> : Returns your color with the set opacity.
- <strong>set_opacity( [$amount] )</strong> : Sets the color with the given opacity.
- <strong>show_opacity( [$amount] )</strong> : Echoes the color with the given opacity.

Any time a value is returned or echoed it will be in the form of an rgba string usable in CSS code. Any time a value is set the `$this->rgba` property is changed. All setters return `$this` which means that methods can be chained.

## Available Conversion methods
- <strong>hexToRgb( $hex )</strong> : Converts an HEX color to RGB
- <strong>rgbToHsl( $rgb )</strong> : Converts a RGB color to HSL
- <strong>hslToRgb( $hsl )</strong> : Converts a HSL color to RGB
- <strong>hueToRGB( $hue )</strong> : Converts a Hue to RGB

All conversion methods are public static methods so may be used outside an instance. Take care as apart from `hexToRGB()` all function need to be passed arrays.

The instance can be echoed any time, in this case it will produce the RGBA string of the color stored in the `$rgba` property.

## Using The Class

```php

// Initialize a color
$color = new Color( '#ec3a34' );

echo $color;
// rgba( 236, 58, 52, 1 );

$color->show_lighten( 10 );
// rgba( 240, 103, 99, 1 )

echo $myBlue->set_lighten( 10 )->get_opacity( 0.7 );
// rgba( 240, 103, 99, 0.7 )

```

## Special Thanks
Special thanks to [mexitek/phpColors](https://github.com/mexitek/phpColors/) for the excellent class I based this one on!