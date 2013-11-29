## How it works
Instantiate an object of the color class with a hex color string `$color = new Color( "#ff9900" )`. Once an object has been created you can use the methods below to manipulate the color.

## Available Manipulation Methods
- <strong>darken( [$amount] )</strong> : Allows you to obtain a darker shade of your color. The default darkening amount is 4%.
- <strong>lighten( [$amount] )</strong> : Allows you to obtain a lighter shade of your color. The default lightening amount is 4%.
- <strong>opacity( [$opacity] )</strong> : Allows you to modify the opacity of your given color. The default amount is 1.

## Available Getter methods
- <strong>getHsl()</strong> : Returns the HSL form of the current color
- <strong>getHex()</strong> : Returns the HEX form of the current color
- <strong>getRgb()</strong> : Returns the RGB form of the current color

## Available Conversion methods
- <strong>rgbToHsl()</strong> : Converts an RGB color to HSL
- <strong>hslToRgb()</strong> : Converts a HSL color to RGB
- <strong>hexToRgb()</strong> : Converts a HEX color to RGB
- <strong>rgbToHex()</strong> : Converts an RGB color to HEX

## Using The Class

```php

// Initialize a color
$color = new Color( '#ec3a34' );

echo $color;
// rgba( 236, 58, 52, 1 );

echo $color->lighten( 10 );
// rgba( 240, 103, 99, 1 )

echo $myBlue->lighten( 10 )->opacity( 0.7 );
// rgba( 240, 103, 99, 0.7 )

```

By default when you manipulate the colors the original color is reset once you display the color. Note that to reset the color you <strong>must</strong> echo it.

```php

// Initialize a color
$color = new Color( '#ec3a34' );

echo $color;
// rgba( 236, 58, 52, 1 );

echo $color->lighten( 10 );
// rgba( 240, 103, 99, 1 )

echo $color;
// rgba( 236, 58, 52, 1 );

```

If you would like the color to retain its modified value even if it has been echoed you can set the <code>$retain</code> parameter when instantiating the object.

```php

// Initialize a color
$color = new Color( '#ec3a34', true );

echo $color;
// rgba( 236, 58, 52, 1 );

echo $color->lighten( 10 );
// rgba( 240, 103, 99, 1 )

echo $color;
// rgba( 240, 103, 99, 1 )

```


## Special Thanks
Special thanks to [mexitek/phpColors](https://github.com/mexitek/phpColors/) for the excellent class I based this one on!