<?php


/**
 * A color utility that helps manipulate HEX colors
 */

class dynamicColor {

	var $rgba;

	/** Class Constructor
	  *
	  * Checks and sets our initial color
	  *
	  * @param string $hex The HEX color string
	  *
	  */
	function __construct( $hex = '' ) {
        $hex = self::_checkHex( $hex );
        $this->rgba = self::hexToRgb( $hex );
	}


	/** Echo Magic Method
	  *
	  * Converts our color to an RGB string before
	  * it is echoed.
	  *
	  * @param string The RGBA color string
	  *
	  */
    public function __toString() {
        return $this->rgbToString( $this->rgba );
    }


	/***********************************************/
	/*               Color Conditions              */
	/***********************************************/

    /** Check Color Darkness
     *
     * Returns whether or not a given color is considered dark
     * given the $threshold
     *
     * @param int $threshold The color threshold
     *
     * @return boolean
     *
     */
    public function isDark( $threshold = 130 ) {
        return ( ( $this->rgba['R'] * 299 + $this->rgba['G'] * 587 + $this->rgba['B'] * 114 ) / 1000 <= $threshold );
    }

    /** Check Color Lightness
     *
     * Returns whether or not a given color is considered light
     * given the $threshold
     *
     * @param int $threshold The color threshold
     *
     * @return boolean
     *
     */
    public function isLight( $threshold = 130, $color = false ){
        return ( ( $this->rgba['R'] * 299 + $this->rgba['G'] * 587 + $this->rgba['B'] * 114 ) / 1000 > $threshold );
    }


	/***********************************************/
	/*              Color Manipulation             */
	/***********************************************/

	/** Darken Color
	  *
	  * This is the core function which modifies the darkness
	  * of the current color
	  *
	  * @param int $amount The percentage of darkening
	  *
	  * @return array RGBA color array
	  *
	  */
	function _darken( $amount ) {
		$hsl = self::rgbToHsl( $this->rgba );
		$hsl['L'] = ($hsl['L'] * 100) - $amount;
		$hsl['L'] = ($hsl['L'] < 0) ? 0:$hsl['L']/100;
        return self::hslToRgb( $hsl );
	}

	/** Darken Color And Return Color String
	  *
	  * Darkens the current color by $amount percentage
	  * and returns the resulting color string
	  *
	  * @param int $amount The percentage of darkening
	  *
	  * @return string RGBA color string
	  *
	  */
    public function darken( $amount = 4 ){
        return $this->rgbToString( $this->_darken( $amount ) );
    }

	/** Darken Color And Set Color
	  *
	  * Darkens the current color by $amount percentage
	  * and sets it as the color
	  *
	  * @param int $amount The percentage of darkening
	  *
	  * @return self
	  *
	  */
    public function set_darken( $amount = 4 ){
	    $this->rgba = $this->_darken( $amount );
        return $this;
    }

	/** Darken Color And Set Color
	  *
	  * Darkens the current color by $amount percentage
	  * and echos the color string
	  *
	  * @param int $amount The percentage of darkening
	  *
	  */
    public function show_darken( $amount = 4 ){
        echo $this->darken( $amount );
    }


	/** Lighten Color
	  *
	  * This is the core function which modifies the lightness
	  * of the current color
	  *
	  * @param int $amount The percentage of lightening
	  *
	  * @return array RGBA color array
	  *
	  */
	function _lighten( $amount ) {
		$hsl = self::rgbToHsl( $this->rgba );
        $hsl['L'] = ($hsl['L'] * 100) + $amount;
        $hsl['L'] = ($hsl['L'] > 100) ? 1:$hsl['L']/100;
        return self::hslToRgb( $hsl );
	}


	/** Lighten Color And Return Color String
	  *
	  * Lightens the current color by $amount percentage
	  * and returns the resulting color string
	  *
	  * @param int $amount The percentage of lightening
	  *
	  * @return string RGBA color string
	  *
	  */
    public function lighten( $amount = 4 ){
        return $this->rgbToString( $this->_lighten( $amount ) );
    }

	/** Lighten Color And Set Color
	  *
	  * Lightens the current color by $amount percentage
	  * and sets it as the color
	  *
	  * @param int $amount The percentage of lightening
	  *
	  * @return self
	  *
	  */
    public function set_lighten( $amount = 4 ){
	    $this->rgba = $this->_lighten( $amount );
        return $this;
    }


	/** Lighten Color And Set Color
	  *
	  * Lightens the current color by $amount percentage
	  * and echos the color string
	  *
	  * @param int $amount The percentage of lightening
	  *
	  */
    public function show_lighten( $amount = 4 ){
        echo $this->lighten( $amount );
    }


	/** Modify Opacity
	  *
	  * This is the core function which modifies the opacity of
	  * the current color
	  *
	  * @param float|int Opacity to set
	  *
	  * @return array RGBA color array
	  *
	  */
	private function _opacity( $opacity = 1  ) {
    	$rgba = $this->rgba;
		$rgba['A'] = $opacity;
		return $rgba;
	}

    /** Modify Opacity And Return Color String
     *
     * Modifies the opacity of our current color to the given
     * $opacity and returns the resulting color array
     *
     * @param float|int $opacity
	 *
	 * @return array RGBA color array
	 *
	 */
    public function opacity( $opacity = 1 ){
        return $this->rgbToString( $this->_opacity( $opacity ) );
    }

    /** Modify Opacity And Set Color
     *
     * Modifies the opacity of our current color to the given
     * $opacity and sets it as the new color value
     *
     * @param float|int $opacity
	 *
	 * @return self
	 *
	 */
    public function set_opacity( $opacity = 1 ){
	    $this->rgba = $this->_opacity( $opacity );
        return $this;
    }

    /** Modify Opacity And Echo Color String
     *
     * Modifies the opacity of our current color to the given
     * $opacity and echoes the resulting color string
     *
     * @param float|int $opacity
	 *
	 */
    public function show_opacity( $opacity = 1 ){
        echo $this->opacity( $opacity );
    }


	/***********************************************/
	/*                    Checks                   */
	/***********************************************/

    /** HEX Checker
     * Checks if a HEX is properly formatted. It accept values
     * with our without the pound sign. If a color is invalid it
     * defaults to #ffffff to make sure no errors happen
     *
     * @param string $hex
     * @return string HEX Color
     *
     */
    private static function _checkHex( $hex ) {
        // Strip # sign is present
        $color = str_replace("#", "", $hex);

        // Make sure it's 6 digits
        if( strlen($color) == 3 ) {
            $color = $color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
        } else if( strlen($color) != 6 ) {
            $color = 'ffffff';
        }


        return $color;
    }


	/***********************************************/
	/*                 Conversions                 */
	/***********************************************/

    /** HEX To RGB Conversion
     *
     * Given a HEX string returns a RGB array equivalent.
     *
     * @param string $color
     *
     * @return array RGB associative array
     *
     */
    public static function hexToRgb( $color ){

        // Convert HEX to DEC
        $R = hexdec($color[0].$color[1]);
        $G = hexdec($color[2].$color[3]);
        $B = hexdec($color[4].$color[5]);

        $RGB['R'] = $R;
        $RGB['G'] = $G;
        $RGB['B'] = $B;
        $RGB['A'] = 1;

        return $RGB;
    }

    /** RGB To HSL Conversion
     *
     * Given an RGBA array returns a HSL array equivalent.
     *
     * @param array $rgb
     *
     * @return array HSL associative array
	 *
     */
    public static function rgbToHsl( $rgb ){

        $R = $rgb['R'];
        $G = $rgb['G'];
        $B = $rgb['B'];

        $HSL = array();

        $var_R = ( $R / 255 );
        $var_G = ( $G / 255 );
        $var_B = ( $B / 255 );

        $var_Min = min( $var_R, $var_G, $var_B );
        $var_Max = max( $var_R, $var_G, $var_B );
        $del_Max = $var_Max - $var_Min;

        $L = ( $var_Max + $var_Min ) / 2;

        if ( $del_Max == 0 ) {
            $H = 0;
            $S = 0;
        }
        else {
            if ( $L < 0.5 ) {
            	$S = $del_Max / ( $var_Max + $var_Min );
            }
            else {
            	$S = $del_Max / ( 2 - $var_Max - $var_Min );
            }

            $del_R = ( ( ( $var_Max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
            $del_G = ( ( ( $var_Max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
            $del_B = ( ( ( $var_Max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

            if ( $var_R == $var_Max ) {
            	$H = $del_B - $del_G;
            }
            elseif ( $var_G == $var_Max ) {
            	$H = ( 1 / 3 ) + $del_R - $del_B;
            }
            elseif ( $var_B == $var_Max ) {
            	$H = ( 2 / 3 ) + $del_G - $del_R;
            }

            if ( $H < 0 ) {
            	$H++;
            }
            if ( $H > 1 ) {
            	$H--;
            }
        }

        $HSL['H'] = ( $H * 360 );
        $HSL['S'] = $S;
        $HSL['L'] = $L;

        if( !empty( $rgb['A'] ) ) {
        	$HSL['A'] = $rgb['A'];
        }

        return $HSL;
    }

    /** HSL To RGB Conversion
     *
     * Given a HSL associative array returns the equivalent RGB Array
     *
     * @param array $hsl
     *
     * @return array RGB array
	 *
     */
    public static function hslToRgb( $hsl = array() ){

        list ( $H, $S, $L ) = array( $hsl['H'] / 360, $hsl['S'], $hsl['L'] );

        if ( $S == 0 ) {
            $r = round( $L * 255 );
            $g = round( $L * 255 );
            $b = round( $L * 255 );
        }
        else {
            if ( $L < 0.5 ) {
                $var_2 = $L * ( 1 + $S );
            } else {
                $var_2 = ( $L + $S ) - ( $S * $L );
            }

            $var_1 = 2 * $L - $var_2;

            $r = round( 255 * self::_huetorgb( $var_1, $var_2, $H + ( 1 / 3 ) ) );
            $g = round( 255 * self::_huetorgb( $var_1, $var_2, $H ) );
            $b = round( 255 * self::_huetorgb( $var_1, $var_2, $H - ( 1 / 3 ) ) );

        }

		$rgb = array( 'R' => $r, 'G' => $g, 'B' => $b );

		if( !empty( $hsl['A'] ) ) {
			$rgb['A'] = $hsl['A'];
		}

        return $rgb;
    }

    /** RGB Array To RGB String
     *
     * Converts an rgba or rgb array to a string usable
     * in CSS.
     *
     * @param array $rgb
     *
     * @return string RGBA string
	 *
     */
    public static function rgbToString( $rgb ) {
        return 'rgba( ' . implode( ',', $rgb ) . ')';
	}



}