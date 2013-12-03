<?php

/**
 * Author: Daniel Pataki <http://danielpataki.com>
 * Info: http://danielpataki.github.io/dynamicColor/
 * License: http://danielpataki.mit-license.org/
 */

/**
 * A color utility that helps manipulate HEX colors
 */
class dynamicColor {

    private $_originalColor;
    private $_color;

    /**
     * Instantiates the class with a HEX value
     * @param string $hex
     */
    function __construct( $hex, $retain = false ) {

        $hex = self::_checkHex($hex);

        $this->_color = self::hexToRgb( $hex );
		$this->_originalColor = $this->_color;

        $this->_retain = $retain;
    }

    // ====================
    // = Public Interface =
    // ====================

    /**
     * Darkens our current color by the given $amount
     *
     * @param int $amount
     * @return self
     */
    public function darken( $amount = 4 ){
		$hsl = self::rgbToHsl( $this->_color );
		$hsl['L'] = ($hsl['L'] * 100) - $amount;
		$hsl['L'] = ($hsl['L'] < 0) ? 0:$hsl['L']/100;
	    $this->_color = self::hslToRgb( $hsl );
        return $this;
    }

    /**
     * Lightens our current color by the given $amount
     *
     * @param int $amount
     * @return self
     */
    public function lighten( $amount = 4 ){
		$hsl = self::rgbToHsl( $this->_color );
        $hsl['L'] = ($hsl['L'] * 100) + $amount;
        $hsl['L'] = ($hsl['L'] > 100) ? 1:$hsl['L']/100;
        $this->_color = self::hslToRgb( $hsl );
    	return $this;
    }

    /**
     * It modifies the opacity value of our color to the given $opacity
     * @param int $opacity
     * @return self
     */
    public function modifyOpacity( $opacity = 1 ){
		$this->_color['A'] = $opacity;
		return $this;
    }


	/***********************************************/
	/*                 Conversion                  */
	/***********************************************/

    /**
     * Given an RGBA array returns a HSL array equivalent.
     * @param array $rgb
     * @return array HSL associative array
     * @throws Exception "Bad RGB Array"
     */
    public static function rgbToHsl( $rgb ){

        // Sanity check
        $rgb = self::_checkRgb($rgb);

        $R = $rgb['R'];
        $G = $rgb['G'];
        $B = $rgb['B'];

        $HSL = array();

        $var_R = ($R / 255);
        $var_G = ($G / 255);
        $var_B = ($B / 255);

        $var_Min = min($var_R, $var_G, $var_B);
        $var_Max = max($var_R, $var_G, $var_B);
        $del_Max = $var_Max - $var_Min;

        $L = ($var_Max + $var_Min)/2;

        if ($del_Max == 0)
        {
            $H = 0;
            $S = 0;
        }
        else
        {
            if ( $L < 0.5 ) $S = $del_Max / ( $var_Max + $var_Min );
            else            $S = $del_Max / ( 2 - $var_Max - $var_Min );

            $del_R = ( ( ( $var_Max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
            $del_G = ( ( ( $var_Max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
            $del_B = ( ( ( $var_Max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

            if      ($var_R == $var_Max) $H = $del_B - $del_G;
            else if ($var_G == $var_Max) $H = ( 1 / 3 ) + $del_R - $del_B;
            else if ($var_B == $var_Max) $H = ( 2 / 3 ) + $del_G - $del_R;

            if ($H<0) $H++;
            if ($H>1) $H--;
        }

        $HSL['H'] = ($H*360);
        $HSL['S'] = $S;
        $HSL['L'] = $L;

        if( !empty( $rgb['A'] ) ) {
        	$HSL['A'] = $rgb['A'];
        }

        return $HSL;
    }

    /**
     * Given a HSL associative array returns the equivalent RGB Array
     * @param array $hsl
     * @return array RGB array
     * @throws Exception "Bad HSL Array"
     */
    public static function hslToRgb( $hsl = array() ){

        // Sanity check
        $hsl = self::_checkHsl($hsl);

        list($H,$S,$L) = array( $hsl['H']/360,$hsl['S'],$hsl['L'] );

        if( $S == 0 ) {
            $r = round( $L * 255 );
            $g = round( $L * 255 );
            $b = round( $L * 255 );
        } else {

            if($L<0.5) {
                $var_2 = $L*(1+$S);
            } else {
                $var_2 = ($L+$S) - ($S*$L);
            }

            $var_1 = 2 * $L - $var_2;

            $r = round(255 * self::_huetorgb( $var_1, $var_2, $H + (1/3) ));
            $g = round(255 * self::_huetorgb( $var_1, $var_2, $H ));
            $b = round(255 * self::_huetorgb( $var_1, $var_2, $H - (1/3) ));

        }

		$rgb = array( 'R' => $r, 'G' => $g, 'B' => $b );

		if( !empty( $hsl['A'] ) ) {
			$rgb['A'] = $hsl['A'];
		}

        return $rgb;
    }


    /**
     * Given a HEX string returns a RGB array equivalent.
     * @param string $color
     * @return array RGB associative array
     */
    public static function hexToRgb( $color ){

        // Sanity check
        $color = self::_checkHex($color);

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


    /**
     * Given an RGB associative array returns the equivalent HEX string
     * @param array $rgb
     * @return string HEX Value
     * @throws Exception "Bad RGB Array"
     */
    public static function rgbToHex( $rgb ){

        // Sanity check
        $color = self::_checkRgb($color);

        // Convert RGB to HEX
        $hex[0] = dechex( $rgb['R'] );
        $hex[1] = dechex( $rgb['G'] );
        $hex[2] = dechex( $rgb['B'] );

        return implode( '', $hex );

  }

	/***********************************************/
	/*             Get Specific Formats            */
	/***********************************************/

    /**
     * Returns your color's HSL array
     */
    public function getHsl() {
		return self::rgbToHsl( $this->_color );
    }
    /**
     * Returns your original color
     */
    public function getHex() {
		return self::rgbToHex( $this->_color );
    }
    /**
     * Returns your color's RGB array
     */
    public function getRgb() {
        return $this->_color;
    }

    public function __toString()
    {
        return $this->_colorDisplay();
    }

    // ===========================
    // =    Private Functions    =
    // ===========================


    /**
     * Given a Hue, returns corresponding RGB value
     * @param type $v1
     * @param type $v2
     * @param type $vH
     * @return int
     */
    private static function _huetorgb( $v1,$v2,$vH ) {
        if( $vH < 0 ) {
            $vH += 1;
        }

        if( $vH > 1 ) {
            $vH -= 1;
        }

        if( (6*$vH) < 1 ) {
               return ($v1 + ($v2 - $v1) * 6 * $vH);
        }

        if( (2*$vH) < 1 ) {
            return $v2;
        }

        if( (3*$vH) < 2 ) {
            return ($v1 + ($v2-$v1) * ( (2/3)-$vH ) * 6);
        }

        return $v1;

    }


    /**
     * You need to check if you were given a good hex string
     * @param string $hex
     * @return string Color
     * @throws Exception "Bad color format"
     */
    private static function _checkHex( $hex ) {
        // Strip # sign is present
        $color = str_replace("#", "", $hex);

        // Make sure it's 6 digits
        if( strlen($color) == 3 ) {
            $color = $color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
        } else if( strlen($color) != 6 ) {
            throw new Exception("HEX color needs to be 6 or 3 digits long");
        }

        return $color;
    }

    /**
     * You need to check if you were given a good rgb array
     * @param array $rgb
     * @return array RGB Color
     * @throws Exception "Bad color format"
     */
    private static function _checkRgb( $rgb ) {

        if( empty($rgb) || !isset($rgb["R"]) || !isset($rgb["G"]) || !isset($rgb["B"]) ) {
            throw new Exception("Param was not an RGB array");
        }

        return $rgb;
    }


    /**
     * You need to check if you were given a good hex string
     * @param string $hex
     * @return string Color
     * @throws Exception "Bad color format"
     */
    private static function _checkHsl( $hsl ) {

        if( empty($hsl) || !isset($hsl["H"]) || !isset($hsl["S"]) || !isset($hsl["L"]) ) {
            throw new Exception("Param was not an HSL array");
        }

        return $hsl;
    }

    private function _colorDisplay( $color = null ) {
    	if( $color == null ) {
			$color = $this->_color;
		}

		if( $this->_retain == false ) {
			$this->_color = $this->_originalColor;
		}

		return "rgba( $color[R], $color[G], $color[B], $color[A])";

    }


}