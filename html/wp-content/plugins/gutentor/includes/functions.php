<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Convert into RBG Color
 * gutentor_rgb_string
 *
 * @param  [mix] $var
 * @return [boolean]
 */
if (!function_exists('gutentor_isset')) {
    function gutentor_isset( $var ){
        if ( isset( $var ) ) {
            return $var;
        }
        else{
            return '';
        }
    }
}

/**
 * Convert boolean to string
 * gutentor_boolean_to_string
 *
 * @param  [mix] $var
 * @return [boolean]
 */
if (!function_exists('gutentor_boolean_to_string')) {
    function gutentor_boolean_to_string( $var ) {
        if ( $var ) {
            return 'true';
        }
        else{
            return 'false';
        }
    }
}

/**
 * Convert into RBG Color
 * gutentor_rgb_string
 *
 * @param  [mix] $rgba
 * @return boolean | string
 */
if (!function_exists('gutentor_rgb_string')) {
    function gutentor_rgb_string( $rgba )
    {
        if (!is_array( $rgba )) {
            return null;
        }
        $roundA = round(100 * $rgba['a']) / 100;
        return "rgba(" . round($rgba["r"]) . ", " . round($rgba['g']) . ", " . round($rgba['b']) . ", " . $roundA . ")";
    }
}

/**
 * Gutentor String Concat with space 
 * gutentor_rgb_string
 *
 * @param  [mix] $rgba
 * @return boolean | string
 */
if (!function_exists('gutentor_concat_space')) {
    function gutentor_concat_space($data1,$data2 ) {
        if($data2 === null || empty($data2)){
            return $data1;
        }
        else{
            return $data1.' '.$data2;
        }
    }
}

/**
 * Check Empty
 * gutentor_not_empty
 *
 * @param  [mix] $var
 * @return [boolean]
 */
if (!function_exists('gutentor_not_empty')){

    function gutentor_not_empty($var){
        if( trim( $var ) ==='') {
            return false;
        }
        return true;
    }
}

/**
 * Gutentor Unit Type
 * gutentor_unit_type
 *
 * @param  [mix] $type
 * @return string
 */
if (!function_exists('gutentor_unit_type')){

    function gutentor_unit_type($type){
        if($type == 'px') {
            return 'px';
        }
        elseif($type == 'vh') {
            return 'vh';
        }else{
            return '%';
        }
    }
}

/**
 * Generate Css
 * gutentor_generate_css
 *
 * @param  [mix] $prop
 * @param  [mix] $value
 *
 * @return [string]
 */
if (!function_exists('gutentor_generate_css')) {

    function gutentor_generate_css($prop, $value) {
        if(!is_string($prop) || !is_string($value) ){
            return '';
        }
        if ($value) {
            return '' . $prop . ': ' . $value . ';';
        }
        return '';
    }
}

/**
 * Get post excerpt
 *
 * @return string
 */
if (!function_exists('gutentor_get_excerpt_by_id')) {
    function gutentor_get_excerpt_by_id( $post_id, $excerpt_length = 200 ) {
        $the_post    = get_post($post_id);
        $the_excerpt = $the_post->post_content;

        /*remove style tags*/
	    $the_excerpt = preg_replace('~<style(.*?)</style>~Usi', "", $the_excerpt);
        $the_excerpt = preg_replace('`\[[^\]]*\]`', '', $the_excerpt);
        $the_excerpt = strip_tags(strip_shortcodes($the_excerpt));
        $the_excerpt = substr($the_excerpt, 0, $excerpt_length) . '…';
        return $the_excerpt;
    }
}

/**
 * Gutentor dynamic CSS
 * @since    1.0.0
 *
 * @param array $dynamic_css
 * 	$dynamic_css = array(
	'all'=>'css',
	'768'=>'css',
	);
 * @return mixed
 */
if (!function_exists('gutentor_get_dynamic_css')) {

    function gutentor_get_dynamic_css($dynamic_css = array()) {

        $getCSS = '';
        $dynamic_css = apply_filters('gutentor_get_dynamic_css', $dynamic_css);

        if (is_array($dynamic_css)) {
            foreach ($dynamic_css as $screen => $css) {
                if ($screen == "all") {

                    if (is_array($css)) {
                        $getCSS .= implode(" ", $css);
                    } else {
                        $getCSS .= $css;
                    }
                }
                elseif ($screen == "tablet") {

                    $getCSS .= '@media (min-width: 720px) {';
                    if (is_array($css)) {
                        $getCSS .= implode(" ", $css);
                    } else {
                        $getCSS .= $css;
                    }
                    $getCSS .= "}";
                }
                elseif ($screen == "desktop") {

                    $getCSS .= '@media (min-width: 992px) {';
                    if (is_array($css)) {
                        $getCSS .= implode(" ", $css);
                    } else {
                        $getCSS .= $css;
                    }
                    $getCSS .= "}";
                }
            }
        }
        $output = $getCSS;

        return $output;
    }
}

/**
 * Gutentor Responsive Height
 * @param  [string] $attributes
 * @param  [string] $device
 * @return [string] mix
 */
if (!function_exists('gutentor_responsive_height_width')) {

    function gutentor_responsive_height_width( $css_attr, $height_width, $device = 'mobile' ){

        if( empty( $height_width ) || ( $height_width == null)){
            return '';
        }
        if( empty( $css_attr ) || ( $css_attr == null)){
            return '';
        }
        $height_width_css = '';
        $unit = $height_width['type'] ? $height_width['type'] : 'px';
        if( $device === 'desktop'){
            $height_width_css = $height_width['desktop']? $height_width['desktop'].$unit: 0;
        }
        else if ( $device === 'tablet' ){
            $height_width_css = $height_width['tablet']? $height_width['tablet'].$unit: 0;
        }
        else{
            $height_width_css = $height_width['mobile']? $height_width['mobile'].$unit: 0;
        }
        return gutentor_generate_css($css_attr,$height_width_css);
    }
}


/**
 * Gutentor Box Four Option Css
 * gutentor_box_four_device_options_css
 *
 * @param  [string] $attributes
 * @param  [string] $device
 * @return [string] mix
 */
if (!function_exists('gutentor_box_four_device_options_css')) {

    function gutentor_box_four_device_options_css($cssAttr, $BoxFourDevices, $device = 'mobile') {

        if ($BoxFourDevices === null || empty($BoxFourDevices)) {
            return false;
        }

        $type = isset($BoxFourDevices['type']) ? $BoxFourDevices['type'] : 'px';
        if ('desktop' === $device) {

            $top    = (isset($BoxFourDevices['desktopTop']) && gutentor_not_empty($BoxFourDevices['desktopTop'])) ? $BoxFourDevices['desktopTop'] : '';
            $right  = (isset($BoxFourDevices['desktopRight']) && gutentor_not_empty($BoxFourDevices['desktopRight'])) ? $BoxFourDevices['desktopRight'] : '';
            $bottom = (isset($BoxFourDevices['desktopBottom']) && gutentor_not_empty($BoxFourDevices['desktopBottom'])) ? $BoxFourDevices['desktopBottom'] : '';
            $left   = (isset($BoxFourDevices['desktopLeft']) && gutentor_not_empty($BoxFourDevices['desktopLeft'])) ? $BoxFourDevices['desktopLeft'] : '';
        } else if ('tablet' === $device) {
            $top    = (isset($BoxFourDevices['tabletTop']) && gutentor_not_empty($BoxFourDevices['tabletTop'])) ? $BoxFourDevices['tabletTop'] : '';
            $right  = (isset($BoxFourDevices['tabletRight']) && gutentor_not_empty($BoxFourDevices['tabletRight'])) ? $BoxFourDevices['tabletRight'] : '';
            $bottom = (isset($BoxFourDevices['tabletBottom']) && gutentor_not_empty($BoxFourDevices['tabletBottom'])) ? $BoxFourDevices['tabletBottom'] : '';
            $left   = (isset($BoxFourDevices['tabletLeft']) && gutentor_not_empty($BoxFourDevices['tabletLeft'])) ? $BoxFourDevices['tabletLeft'] : '';
        } else {
            $top    = (isset($BoxFourDevices['mobileTop']) && gutentor_not_empty($BoxFourDevices['mobileTop'])) ? $BoxFourDevices['mobileTop'] : '';
            $right  = (isset($BoxFourDevices['mobileRight']) && gutentor_not_empty($BoxFourDevices['mobileRight'])) ? $BoxFourDevices['mobileRight'] : '';
            $bottom = (isset($BoxFourDevices['mobileBottom']) && gutentor_not_empty($BoxFourDevices['mobileBottom'])) ? $BoxFourDevices['mobileBottom'] : '';
            $left   = (isset($BoxFourDevices['mobileLeft'])) && gutentor_not_empty($BoxFourDevices['mobileLeft']) ? $BoxFourDevices['mobileLeft'] : '';

        }
        if(gutentor_not_empty($top)  || gutentor_not_empty($right) || gutentor_not_empty($bottom) || gutentor_not_empty($left)) {
	        $top    = ( $top ) ? $top : 0;
	        $right  = ( $right ) ? $right : 0;
	        $bottom = ( $bottom ) ? $bottom : 0;
	        $left   = ( $left ) ? $left : 0;
        }
        $css = gutentor_generate_css($cssAttr, (gutentor_not_empty($top) || gutentor_not_empty($right) || gutentor_not_empty($bottom) || gutentor_not_empty($left)) ? $top . $type . ' ' . $right . $type . ' ' . $bottom . $type . ' ' . $left . $type : null);
        return $css;
    }
}

/**
 * Advanced Background Css
 * @param  [string] $attr
 * @return [string] $css
 */
if (!function_exists('gutentor_advanced_background_css')) {

    function gutentor_advanced_background_css($attr) {

        if(empty($attr)){
            return false;
        }
        $output = '';
        if(isset($attr['blockComponentBGType'])) {
            $advanced_bg_type = $attr['blockComponentBGType'];
            if ($advanced_bg_type == 'image') {
                $advanced_bg_image = isset($attr['blockComponentBGImage']) ? $attr['blockComponentBGImage'] : '';
                $bg_image = '';
                if (is_array($advanced_bg_image)) {
                    $bg_image = $advanced_bg_image['url'];
                }
                if (!empty($bg_image)) {

                    $output .= 'background-image:url("' . $bg_image . '");';
                }
                $advanced_bg_image_size = isset($attr['blockComponentBGImageSize']) ? $attr['blockComponentBGImageSize']: '';
                if (!empty($advanced_bg_image_size)) {
                    $output .= 'background-size:' . $advanced_bg_image_size . ';';
                }
                $advanced_bg_image_position = isset($attr['blockComponentBGImagePosition']) ? $attr['blockComponentBGImagePosition'] : '';
                if (!empty($advanced_bg_image_position)) {

                    $output .= 'background-position:' . $advanced_bg_image_position . ';';
                }
                $advanced_bg_image_repeat = isset($attr['blockComponentBGImageRepeat']) ? $attr['blockComponentBGImageRepeat'] : '';
                if (!empty($advanced_bg_image_repeat)) {

                    $output .= 'background-repeat:' . $advanced_bg_image_repeat . ';';
                }
                $advanced_bg_image_attachment =isset($attr['blockComponentBGImageAttachment']) ? $attr['blockComponentBGImageAttachment'] : '';
                if (!empty($advanced_bg_image_attachment)) {

                    $output .= 'background-attachment:' . $advanced_bg_image_attachment . ';';
                }
            } elseif ($advanced_bg_type == 'color') {
                $advanced_bg_color = isset($attr['blockComponentBGColor']) ? $attr['blockComponentBGColor'] : '';
                $bg_color = '';
                if (is_array($advanced_bg_color)) {
                    $bg_color = gutentor_rgb_string($advanced_bg_color['rgb']);
                }
                if (!empty($bg_color)) {
                    $output .= 'background-color:' . $bg_color . ';';
                }

            }
        }
        return $output;

    }
}

/*
 * Advanced Border Css
 * @param  [string] $attr
 * @return [string] $css
 */
if (!function_exists('gutentor_border_css')) {

    function gutentor_border_css($border_attr){

        if($border_attr === null || empty($border_attr)){
            return false;
        }
        $output = '';
        if ( $border_attr['borderStyle'] != 'none') {

            $output .= 'border-style:' .$border_attr['borderStyle']. ';';
            $border_top    = ( gutentor_not_empty($border_attr['borderTop']) ) ? $border_attr['borderTop'].'px' : '0';
            $border_right  = ( gutentor_not_empty($border_attr['borderRight']) ) ? $border_attr['borderRight'].'px' : '0';
            $border_bottom = ( gutentor_not_empty($border_attr['borderBottom']) )  ? $border_attr['borderBottom'].'px' : '0';
            $border_left   = ( gutentor_not_empty($border_attr['borderLeft']) ) ? $border_attr['borderLeft'].'px' : '0';
            if (gutentor_not_empty($border_top) || gutentor_not_empty($border_right) ||  gutentor_not_empty($border_bottom) ||  gutentor_not_empty($border_left) ){

                $output .= 'border-width:'. $border_top.' '. $border_right.' '. $border_bottom.' '. $border_left.' '.';';
            }
            else{
                $output .= 'border-width:0;';
            }

            $border_color = isset($border_attr['borderColorNormal']) ? $border_attr['borderColorNormal'] : '';
            if($border_color){
                $output .= 'border-color:' . gutentor_rgb_string($border_color['rgb'] ). ';';
            }
            elseif(isset($border_color['hex'])){
                $output .= 'border-color:' . $border_color['hex']. ';';
            }
        }
        $border_radius_type = isset($border_attr['borderRadiusType']) ? $border_attr['borderRadiusType'] : 'px';
        $border_radius_top = isset($border_attr['borderRadiusTop']) ? $border_attr['borderRadiusTop'] : '';
        if (!empty($border_radius_top)){

            $output .= 'border-top-left-radius:' . $border_radius_top.$border_radius_type .';';
        }

        $border_radius_right = isset($border_attr['borderRadiusRight']) ? $border_attr['borderRadiusRight'] : '';
        if (!empty($border_radius_right)){

            $output .= 'border-top-right-radius:' . $border_radius_right.$border_radius_type .';';
        }

        $border_radius_bottom = isset($border_attr['borderRadiusBottom']) ? $border_attr['borderRadiusBottom'] : '';
        if (!empty($border_radius_bottom)){

            $output .= 'border-bottom-right-radius:' . $border_radius_bottom.$border_radius_type .';';
        }

        $border_radius_left = isset($border_attr['borderRadiusLeft']) ? $border_attr['borderRadiusLeft'] : '';
        if (!empty($border_radius_left)){

            $output .= 'border-bottom-left-radius:' . $border_radius_left.$border_radius_type .';';
        }
        return $output;
    }
}

/*
 * Background Image Options
 * gutentor_background_image_options
 *
 * @param  [string] $attr
 * @return [string] $css
 */
if (!function_exists('gutentor_background_image_options')) {

    function gutentor_background_image_options($bg_attr) {

        if ($bg_attr === null || empty($bg_attr)) {
            return false;
        }
        $output          = '';
        $bg_image_height = isset($bg_attr['height']['desktop']) ? $bg_attr['height']['desktop'] : '';
        if (!empty($bg_image_height)) {
            $output .= 'height:' . $bg_image_height . 'px;';
        }
        $bg_image_size = isset($bg_attr['backgroundSize']) ? $bg_attr['backgroundSize'] : '';
        if (!empty($bg_image_size)) {
            $output .= 'background-size:' . $bg_image_size . ';';
        }
        $bg_image_position = isset($bg_attr['backgroundPosition']) ? $bg_attr['backgroundPosition'] : '';
        if (!empty($bg_image_position)) {
            $output .= 'background-position:' . $bg_image_position . ';';
        }
        $bg_image_repeat = isset($bg_attr['backgroundRepeat']) ? $bg_attr['backgroundRepeat'] : '';
        if (!empty($bg_image_repeat)) {
            $output .= 'background-repeat:' . $bg_image_repeat . ';';
        }
        $bg_image_attachment = isset($bg_attr['backgroundAttachment']) ? $bg_attr['backgroundAttachment'] : '';
        if (!empty($bg_image_attachment)) {
            $output .= 'background-attachment:' . $bg_image_attachment . ';';
        }
        return $output;

    }
}

/*
 * Background Responsive Height
 * gutentor_background_responsive_height
 *
 * @param  [string] $attr
 * @return [string] $css
 */
if (!function_exists('gutentor_background_responsive_height')) {

    function gutentor_background_responsive_height($bg_height, $device = 'mobile') {
        if ($bg_height === null || empty($bg_height) || !is_array($bg_height)) {
            return false;
        }
        $output = '';
        $height = ($bg_height['height'][$device]) ? $bg_height['height'][$device] : '';
        if ($height) {
            $output .= 'height:' . $height . 'px;';
        }
        return $output;
    }
}

/*
 * Get Correct Font weight
 * GetCorrectFontWeight
 *
 * @param  [string] $fontWeight
 */
if (!function_exists('GetCorrectFontWeight')) {

	function GetCorrectFontWeight( $fontWeight ) {
		if ( strpos( $fontWeight, 'italic' ) !== false ) {
			$fontWeight = str_replace( "italic", "", $fontWeight );
		}
		if ( 'regular' == $fontWeight ) {
			return $fontWeight = '400';
		}

		return $fontWeight;
	}
}

/*
 * Gutentor Typography
 * gutentor_typography_options_css
 *
 * @param  [string] $typography
 * @return [string] $typography_data
 */
if (!function_exists('gutentor_typography_options_css')) {

    function gutentor_typography_options_css($typography) {
        if ($typography === null || empty($typography)) {
            return false;
        }
        $font_type       = isset($typography['fontType']) ? $typography['fontType'] : '';
        $font_weight     = isset($typography['fontWeight']) ? $typography['fontWeight'] : '';
        $text_transform  = isset($typography['textTransform']) ? $typography['textTransform'] : '';
        $font_style      = isset($typography['fontStyle']) ? $typography['fontStyle'] : '';
        $font_size       = isset($typography['mobileFontSize']) ? $typography['mobileFontSize'] : '';
        $text_decoration = isset($typography['textDecoration']) ? $typography['textDecoration'] : '';
        $line_height     = isset($typography['mobileLineHeight']) ? $typography['mobileLineHeight'] : '';
        $letter_spacing  = isset($typography['mobileLetterSpacing']) ? $typography['mobileLetterSpacing'] : '';

        $typography_data = gutentor_generate_css('font-family', 'default' !== $font_type ? gutentor_font_family($typography, $font_type) : null);
        $typography_data .= gutentor_generate_css('font-size', ('default' !== $font_type && $font_size) ? $font_size . 'px' : null);
	    $typography_data .= gutentor_generate_css('font-weight', ('default' !== $font_type && $font_weight && 'default' !== $font_weight) ? GetCorrectFontWeight($font_weight) : null);
        $typography_data .= gutentor_generate_css('text-transform', ('default' !== $font_type && $text_transform) ? $text_transform : null);
        $typography_data .= gutentor_generate_css('font-style', ('default' !== $font_type && $font_style && 'default' !== $font_style) ? $font_style : null);
        $typography_data .= gutentor_generate_css('text-decoration', ('default' !== $font_type && $text_decoration && 'default' !== $text_decoration) ? $text_decoration : null);
	    $typography_data  .= gutentor_generate_css('line-height', ('default' !== $font_type && $line_height) ? strval($line_height) : null);
        $typography_data .= gutentor_generate_css('letter-spacing', ('default' !== $font_type && $letter_spacing) ? $letter_spacing . 'px' : null);

        return $typography_data;
    }
}

/*
 * Gutentor Typography Font Family
 * font_family
 *
 * @param  [string] $typography
 * @param  [string] $font_type
 * @return [string]
 */
if (!function_exists('gutentor_font_family')) {

    function gutentor_font_family($typography, $font_type) {

        $system_font = isset($typography['systemFont']) ? $typography['systemFont'] : '';
        $google_font = isset($typography['googleFont']) ? $typography['googleFont'] : '';
        $custom_font = isset($typography['customFont']) ? $typography['customFont'] : '';
        if ('default' === $font_type) {
            return '';
        } else if ('system' === $font_type) {
            return str_replace('+', ' ', $system_font);
        } else if ('google' === $font_type) {
            return str_replace('+', ' ', $google_font);
        } else if ('custom' === $font_type) {
            return str_replace('+', ' ', $custom_font);
        } else {
            return '';
        }
    }
}

/*
 * Gutentor Responsive Typography
 * gutentor_typography_options_responsive_css
 *
 * @param  [string] $typography
 * @param  [string] $device
 * @return [string]
 */
if (!function_exists('gutentor_typography_options_responsive_css')) {

    function gutentor_typography_options_responsive_css($typography, $device) {

        $font_type = isset($typography['fontType']) ? $typography['fontType'] : '';
        if ('default' == $font_type) {
            return false;
        }
        if ('desktop' == $device) {

            $font_size      = isset($typography['desktopFontSize']) ? $typography['desktopFontSize'] : '';
            $line_height    = isset($typography['desktopLineHeight']) ? $typography['desktopLineHeight'] : '';
            $letter_spacing = isset($typography['desktopLetterSpacing']) ? $typography['desktopLetterSpacing'] : '';
        } elseif ('tablet' == $device) {
            $font_size      = isset($typography['tabletFontSize']) ? $typography['tabletFontSize'] : '';
            $line_height    = isset($typography['tabletLineHeight']) ? $typography['tabletLineHeight'] : '';
            $letter_spacing = isset($typography['mobileLetterSpacing']) ? $typography['mobileLetterSpacing'] : '';
        }

        $typography_data = gutentor_generate_css('font-size', ('default' !== $font_type && $font_size) ? $font_size . 'px' : null);
        $typography_data .= gutentor_generate_css('line-height', ('default' !== $font_type && $line_height) ? strval($line_height) : null);
        $typography_data .= gutentor_generate_css('letter-spacing', ('default' !== $font_type && $letter_spacing) ? $letter_spacing . 'px' : null);

        return $typography_data;
    }
}

/*
 * Gutentor Button Css #
 * gutentor_button_option_css
 *
 * @param  [string] $typography
 * @param  [string] $device
 * @return [string]
 */
if (!function_exists('gutentor_button_option_css')) {

    function gutentor_button_option_css($button) {

        if ($button === null || empty($button)) {
            return false;
        }

        $TextColor       = $button['textColor'] ? $button['textColor'] : '';
        $TextColorEnable = isset($button['textColor']['enable']) ? $button['textColor']['enable'] : '';
        $BgColor         = $button['bgColor'] ? $button['bgColor'] : '';
        $BgColorEnable   = isset($button['bgColor']['enable']) ? $button['bgColor']['enable'] : '';
        $ButtonMargin    = $button['buttonMargin'] ? $button['buttonMargin'] : '';
        $ButtonPadding   = $button['buttonPadding'] ? $button['buttonPadding'] : '';

        $MarginType   = $ButtonMargin['type'] ? $ButtonMargin['type'] : 'px';
        $MarginTop    = $ButtonMargin['top'] ? $ButtonMargin['top'] : 0;
        $MarginRight  = $ButtonMargin['right'] ? $ButtonMargin['right'] : 0;
        $MarginBottom = $ButtonMargin['bottom'] ? $ButtonMargin['bottom'] : 0;
        $MarginLeft   = $ButtonMargin['left'] ? $ButtonMargin['left'] : 0;

        $PaddingType   = $ButtonPadding['type'] ? $ButtonPadding['type'] : 'px';
        $PaddingTop    = $ButtonPadding['top'] ? $ButtonPadding['top'] : 0;
        $PaddingRight  = $ButtonPadding['right'] ? $ButtonPadding['right'] : 0;
        $PaddingBottom = $ButtonPadding['bottom'] ? $ButtonPadding['bottom'] : 0;
        $PaddingLeft   = $ButtonPadding['left'] ? $ButtonPadding['left'] : 0;

        $css = gutentor_generate_css('color', ($TextColorEnable && $TextColor['normal']) ? $TextColor['normal']['hex'] : null);
        $css .= gutentor_generate_css('background-color', ($BgColorEnable && $BgColor['normal']) ? $BgColor['normal']['hex'] : null);
        $css .= gutentor_generate_css('margin', ($MarginType && ($MarginTop || $MarginRight || $MarginBottom || $MarginLeft)) ? $MarginTop . $MarginType . ' ' . $MarginRight . $MarginType . ' ' . $MarginBottom . $MarginType . ' ' . $MarginLeft . $MarginType : null);
        $css .= gutentor_generate_css('padding', ($PaddingType && ($PaddingTop || $PaddingRight || $PaddingBottom || $PaddingLeft)) ? $PaddingTop . $PaddingType . ' ' . $PaddingRight . $PaddingType . ' ' . $PaddingBottom . $PaddingType . ' ' . $PaddingLeft . $PaddingType : null);
        return $css;
    }
}

/**
 * Box Option Css #
 *
 * @since    1.0.0
 * @access   public
 *
 * @return array | boolean
 */
if (!function_exists('gutentor_box_options_css')) {

    function gutentor_box_options_css($button_options) {

        if ($button_options === null || empty($button_options)) {
            return false;
        }
        $BorderStyle        = $button_options['borderStyle'] ? $button_options['borderStyle'] : '';
        $BorderTop          = $button_options['borderTop'] ? $button_options['borderTop'] : 0;
        $BorderRight        = $button_options['borderRight'] ? $button_options['borderRight'] : 0;
        $BorderBottom       = $button_options['borderBottom'] ? $button_options['borderBottom'] : 0;
        $BorderLeft         = $button_options['borderLeft'] ? $button_options['borderLeft'] : 0;
        $BorderColor        = $button_options['borderColor'] ? $button_options['borderColor'] : '';
        $BorderRadiusType   = $button_options['borderRadiusType'] ? $button_options['borderRadiusType'] : '';
        $BorderRadiusTop    = $button_options['borderRadiusTop'] ? $button_options['borderRadiusTop'] : '';
        $BorderRadiusRight  = $button_options['borderRadiusRight'] ? $button_options['borderRadiusRight'] : '';
        $BorderRadiusBottom = $button_options['borderRadiusBottom'] ? $button_options['borderRadiusBottom'] : '';
        $BorderRadiusLeft   = $button_options['borderRadiusLeft'] ? $button_options['borderRadiusLeft'] : '';
        $BoxShadowColor     = $button_options['boxShadowColor'] ? $button_options['boxShadowColor'] : '';
        $BoxShadowX         = $button_options['boxShadowX'] ? $button_options['boxShadowX'] : '';
        $BoxShadowY         = $button_options['boxShadowY'] ? $button_options['boxShadowY'] : '';
        $BoxShadowBlur      = $button_options['boxShadowBlur'] ? $button_options['boxShadowBlur'] : '';
        $BoxShadowSpread    = $button_options['boxShadowSpread'] ? $button_options['boxShadowSpread'] : '';
        $BoxShadowPosition  = $button_options['boxShadowPosition'] ? $button_options['boxShadowPosition'] : '';


        $css = gutentor_generate_css('border-style', 'none' !== $BorderStyle ? $BorderStyle : null);
        $css .= gutentor_generate_css('border-width', 'none' !== $BorderStyle ? $BorderTop . 'px' . ' ' . $BorderRight . 'px' . ' ' . $BorderBottom . 'px' . ' ' . $BorderLeft . 'px' . ' ' : null);
        $css .= gutentor_generate_css('border-color', ('none' !== $BorderStyle && $BorderColor && $BorderColor['normal']) ? gutentor_rgb_string($BorderColor['normal']['rgb']) : null);
        $css .= gutentor_generate_css('border-top-left-radius', $BorderRadiusTop ? $BorderRadiusTop . $BorderRadiusType : null);
        $css .= gutentor_generate_css('border-top-right-radius', $BorderRadiusRight ? $BorderRadiusRight . $BorderRadiusType : null);
        $css .= gutentor_generate_css('border-bottom-right-radius', $BorderRadiusBottom ? $BorderRadiusBottom . $BorderRadiusType : null);
        $css .= gutentor_generate_css('border-bottom-left-radius', $BorderRadiusLeft ? $BorderRadiusLeft . $BorderRadiusType : null);
        $css .= gutentor_generate_css('box-shadow', ($BoxShadowX && $BoxShadowY && $BoxShadowBlur && $BoxShadowSpread && $BoxShadowColor) ? $BoxShadowX . 'px ' . $BoxShadowY . 'px ' . $BoxShadowBlur . 'px ' . $BoxShadowSpread . 'px ' . gutentor_rgb_string($BoxShadowColor['rgb']) . ' ' . $BoxShadowPosition : null);
        return $css;
    }
}

/**
 * Border Shadow Css
 * @since    1.0.0
 * @access   public
 *
 * @return array | boolean
 */
if (!function_exists('gutentor_border_shadow_css')) {

    function gutentor_border_shadow_css($BoxShadow) {
        if ($BoxShadow === null || empty($BoxShadow)) {
            return false;
        }
        $BoxShadowColor    = $BoxShadow['boxShadowColor'] ? $BoxShadow['boxShadowColor'] : '';
        $BoxShadowX        = gutentor_not_empty($BoxShadow['boxShadowX']) ? $BoxShadow['boxShadowX'].'px' : '';
        $BoxShadowY        = gutentor_not_empty($BoxShadow['boxShadowY']) ? $BoxShadow['boxShadowY'].'px' : '';
        $BoxShadowBlur        = gutentor_not_empty($BoxShadow['boxShadowBlur']) ? $BoxShadow['boxShadowBlur'].'px' : '';
        $BoxShadowSpread   = $BoxShadow['boxShadowSpread'] ? $BoxShadow['boxShadowSpread'] : '';
        $BoxShadowSpread        = gutentor_not_empty($BoxShadow['boxShadowSpread']) ? $BoxShadow['boxShadowSpread'].'px' : '';
        $BoxShadowPosition = $BoxShadow['boxShadowPosition'] ? $BoxShadow['boxShadowPosition'] : '';
        $css = gutentor_generate_css('box-shadow',($BoxShadowX && $BoxShadowY && $BoxShadowBlur && $BoxShadowSpread && $BoxShadowColor) ? $BoxShadowX.' '.$BoxShadowY.' '.$BoxShadowBlur.' '.$BoxShadowSpread .' '. gutentor_rgb_string($BoxShadowColor['rgb']) . ' ' . $BoxShadowPosition : null);
        return $css;
    }
}

/**
 * Button Option HoverCss
 * gutentor_button_option_hover_css
 *
 * @since    1.0.0
 * @access   public
 *
 * @return array | boolean
 */
if (!function_exists('gutentor_button_option_hover_css')) {

    function gutentor_button_option_hover_css($button) {
        if ($button === null || empty($button)) {
            return false;
        }
        $TextColor       = $button['textColor'] ? $button['textColor'] : '';
        $TextColorEnable = isset($button['textColor']['enable']) ? $button['textColor']['enable'] : '';
        $BgColor         = $button['bgColor'] ? $button['bgColor'] : '';
        $BgColorEnable   = isset($button['bgColor']['enable']) ? $button['bgColor']['enable'] : '';
        $BorderStyle     = $button['buttonBoxOptions']['borderStyle'] ? $button['buttonBoxOptions']['borderStyle'] : '';
        $BorderColor     = $button['buttonBoxOptions']['borderColor'] ? $button['buttonBoxOptions']['borderColor'] : '';

        $css = gutentor_generate_css('color', ($TextColorEnable && $TextColor['hover']) ? $TextColor['hover']['hex'] : null);
        $css .= gutentor_generate_css('border-color', 'none' !== $BorderStyle && $BorderColor['hover'] ? gutentor_rgb_string($BorderColor['hover']['rgb']) : null);
        $css .= gutentor_generate_css('background-color', ($BgColorEnable && $BgColor['hover']) ? gutentor_rgb_string($BgColor['hover']['rgb']) : null);
        return $css;
    }
}

/**
 * Button Icon Css
 * gutentor_button_option_hover_css
 *
 * @since    1.0.0
 * @access   public
 *
 * @return array | boolean
 */
if (!function_exists('gutentor_button_option_hover_css')) {

    function gutentor_button_option_hover_css($button) {
        if ($button === null || empty($button)) {
            return false;
        }
        $IconSize    = $button['iconSize'] ? $button['iconSize'] : '';
        $IconMargin  = $button['iconMargin'] ? $button['iconMargin'] : '';
        $IconPadding = $button['iconPadding'] ? $button['iconPadding'] : '';

        $MarginType   = isset($button['iconMargin']['type']) ? $button['iconMargin']['type'] : 'px';
        $MarginTop    = isset($IconMargin['top']) ? $IconMargin['top'] : 0;
        $MarginRight  = isset($IconMargin['right']) ? $IconMargin['right'] : 0;
        $MarginBottom = isset($IconMargin['bottom']) ? $IconMargin['bottom'] : 0;
        $MarginLeft   = isset($IconMargin['left']) ? $IconMargin['left'] : 0;

        $PaddingType   = isset($button['iconPadding']['type']) ? $button['iconPadding']['type'] : 'px';
        $PaddingTop    = isset($IconPadding['top']) ? $IconPadding['top'] : 0;
        $PaddingRight  = isset($IconPadding['right']) ? $IconPadding['right'] : 0;
        $PaddingBottom = isset($IconPadding['bottom']) ? $IconPadding['bottom'] : 0;
        $PaddingLeft   = isset($IconPadding['left']) ? $IconPadding['left'] : 0;

        $css = gutentor_generate_css('margin', $IconMargin && ($MarginTop || $MarginRight || $MarginBottom || $MarginLeft) ? $MarginTop . $MarginType . ' ' . $MarginRight . $MarginType . ' ' . $MarginBottom . $MarginType . ' ' . $MarginLeft . $MarginType : null);
        $css .= gutentor_generate_css('padding', $IconPadding && ($PaddingTop || $PaddingRight || $PaddingBottom || $PaddingLeft) ? $PaddingTop . $PaddingType . ' ' . $PaddingRight . $PaddingType . ' ' . $PaddingBottom . $PaddingType . ' ' . $PaddingLeft . $PaddingType : null);
        $css .= gutentor_generate_css('font-size', $IconSize ? $IconSize . 'px' : null);
        return $css;

    }
}

/**
 * Gutentor Button Css
 * GutentorButtonCss
 * @since    1.0.0
 * @access   public
 *
 * @return array | boolean
 */
if (!function_exists('GutentorButtonCss')) {

    function GutentorButtonCss($buttonStyleAttributes) {

        if ($buttonStyleAttributes === null || empty($buttonStyleAttributes)) {
            return false;
        }
        $local_dynamic_css            = array();
        $local_dynamic_css['all']     = '';
        $local_dynamic_css['tablet']  = '';
        $local_dynamic_css['desktop'] = '';
        $blockID                      = ($buttonStyleAttributes['blockID']) ? $buttonStyleAttributes['blockID'] : '';
        $buttonColor                  = ($buttonStyleAttributes['buttonColor']) ? $buttonStyleAttributes['buttonColor'] : '';
        $buttonColorEnable            = ($buttonColor['enable']) ? $buttonColor['enable'] : '';
        $buttonTextColor              = ($buttonStyleAttributes['buttonTextColor']) ? $buttonStyleAttributes['buttonTextColor'] : '';
        $buttonTextColorEnable        = ($buttonTextColor['enable']) ? $buttonTextColor['enable'] : '';
        $buttonMargin                 = isset($buttonStyleAttributes['buttonMargin']) ? $buttonStyleAttributes['buttonMargin'] : '';
        $buttonPadding                = isset($buttonStyleAttributes['buttonPadding']) ? $buttonStyleAttributes['buttonPadding'] : '';
        $buttonIconOptions            = ($buttonStyleAttributes['buttonIconOptions']) ? $buttonStyleAttributes['buttonIconOptions'] : '';
        $buttonIconMargin             = ($buttonStyleAttributes['buttonIconMargin']) ? $buttonStyleAttributes['buttonIconMargin'] : '';
        $buttonIconPadding            = ($buttonStyleAttributes['buttonIconPadding']) ? $buttonStyleAttributes['buttonIconPadding'] : '';
        $buttonBorder                 = isset($buttonStyleAttributes['buttonBorder']['borderStyle']) ? $buttonStyleAttributes['buttonBorder'] : '';
        $buttonBoxShadow              = isset($buttonStyleAttributes['buttonBoxShadow']['boxShadowColor']) ? $buttonStyleAttributes['buttonBoxShadow'] : '';
        $buttonTypography             = ($buttonStyleAttributes['buttonTypography']) ? $buttonStyleAttributes['buttonTypography'] : '';
        $buttonClass                  = ($buttonStyleAttributes['buttonClass']) ? $buttonStyleAttributes['buttonClass'] : '';

        $local_dynamic_css['all'] .= '#section-' . $blockID . ' .' . $buttonClass . '{
          ' . gutentor_generate_css('color', ($buttonTextColorEnable && isset($buttonTextColor['normal'])) ? $buttonTextColor['normal']['hex'] : null) . '
          ' . gutentor_generate_css('background', ($buttonColorEnable && isset($buttonColor['normal']) && isset($buttonColor['normal']['rgb'])) ? gutentor_rgb_string($buttonColor['normal']['rgb']) : null) . '
          ' . gutentor_box_four_device_options_css('margin', $buttonMargin) . '
          ' . gutentor_box_four_device_options_css('padding', $buttonPadding) . '
          ' . gutentor_border_css($buttonBorder) . '
          ' . gutentor_border_shadow_css($buttonBoxShadow) . '
          ' . gutentor_typography_options_css($buttonTypography) . '
        }';

        $local_dynamic_css['all'] .= '#section-' . $blockID . ' .' . $buttonClass . ':hover{
          ' . gutentor_generate_css('color', ($buttonTextColorEnable && isset($buttonTextColor['hover']) && isset($buttonTextColor['hover']['hex'])) ? $buttonTextColor['hover']['hex'] : null) . '
          ' . gutentor_generate_css('background', ($buttonColorEnable && isset($buttonColor['hover']) && isset($buttonColor['hover']['rgb'])) ? gutentor_rgb_string($buttonColor['hover']['rgb']) : null) . '
          ' . gutentor_generate_css('border-color', ($buttonBorder && $buttonBorder['borderStyle'] != 'none' && isset($buttonBorder['borderColorHover']['rgb'])) ? gutentor_rgb_string($buttonBorder['borderColorHover']['rgb']) : null) . '
        }';

        $local_dynamic_css['tablet'] .= '#section-' . $blockID . ' .' . $buttonClass . '{
          ' . gutentor_box_four_device_options_css('margin', $buttonMargin, 'tablet') . '
          ' . gutentor_box_four_device_options_css('padding', $buttonPadding, 'tablet') . '
          ' . gutentor_typography_options_responsive_css($buttonTypography, 'tablet') . '
        }';

        $local_dynamic_css['desktop'] .= '#section-' . $blockID . ' .' . $buttonClass . '{
          ' . gutentor_box_four_device_options_css('margin', $buttonMargin, 'desktop') . '
          ' . gutentor_box_four_device_options_css('padding', $buttonPadding, 'desktop') . '
          ' . gutentor_typography_options_responsive_css($buttonTypography, 'desktop') . '
        }';

        /* Button Icon Css*/
        $local_dynamic_css['all'] .= '#section-' . $blockID . ' .' . $buttonClass . ' .gutentor-button-icon{
          ' . gutentor_box_four_device_options_css('margin', $buttonIconMargin) . '
          ' . gutentor_box_four_device_options_css('padding', $buttonIconPadding) . '
          ' . gutentor_generate_css('font-size', (isset($buttonIconOptions['size']) && gutentor_not_empty($buttonIconOptions['size'])) ? $buttonIconOptions['size'] . 'px' : null) . '
        }';

        $local_dynamic_css['tablet'] .= '#section-' . $blockID . ' .' . $buttonClass . ' .gutentor-button-icon{
          ' . gutentor_box_four_device_options_css('margin', $buttonIconMargin, 'tablet') . '
          ' . gutentor_box_four_device_options_css('padding', $buttonIconPadding, 'tablet') . '
        }';

        $local_dynamic_css['desktop'] .= '#section-' . $blockID . ' .' . $buttonClass . ' .gutentor-button-icon{
          ' . gutentor_box_four_device_options_css('margin', $buttonIconMargin, 'desktop') . '
          ' . gutentor_box_four_device_options_css('padding', $buttonIconPadding, 'desktop') . '
        }';

        return $local_dynamic_css;

    }
}

/**
 *  GutentorButtonOptionsClasses
 *
 * @since Gutentor 1.0.0
 *
 * @param null
 * @return string
 *
 */
if (!function_exists('GutentorButtonOptionsClasses')) {

    function GutentorButtonOptionsClasses($button) {

        if ($button === null || empty($button)) {
            return false;
        }
        $position = isset($button['position']) ? $button['position'] : '';
        $size     = isset($button['size']) ? $button['size'] : '';
        $position   = 'gutentor-icon-' . $position;
        $output   = gutentor_concat_space($position,$size);
        return $output;
    }
}


/**
 *  GutentorBackgroundOptionsCSSClasses
 *
 * @since Gutentor 1.0.0
 *
 * @param null
 * @return string
 *
 */
if (!function_exists('GutentorBackgroundOptionsCSSClasses')) {

    /**
     * Background Classes
     * @param {string} backgroundType - The Background type
     * @return {array} The inline CSS class.
     */
    function GutentorBackgroundOptionsCSSClasses( $backgroundType ) {

        if ($backgroundType === null || empty($backgroundType)) {
            return false;
        }
        if('image' === $backgroundType){
            return 'has-image-bg has-custom-bg';
        }
        elseif('color' === $backgroundType){
            return 'has-color-bg has-custom-bg';
        }  
        elseif('video' === $backgroundType){
            return 'has-video-bg has-custom-bg';
        }
    }
}

/**
 *  GutentorBoxSingleDeviceNegativeSpacing
 *
 * @since Gutentor 1.0.0
 *
 * @param null
 * @return string
 *
 */
if (!function_exists('GutentorBoxSingleDeviceNegativeSpacing')) {

    function GutentorBoxSingleDeviceNegativeSpacing( $cssAttr, $BoxFourDevices, $deviceAttr = '' ){

        if(empty($BoxFourDevices) || $BoxFourDevices == null){
            return '';

        }
        $type = $BoxFourDevices && $BoxFourDevices['type'] ? $BoxFourDevices['type']:'px';

        if( 'desktopTop' === $deviceAttr ) {
            $top = $BoxFourDevices && $BoxFourDevices['desktopTop'] ? $BoxFourDevices['desktopTop'] : 0;
            $css = gutentor_generate_css( $cssAttr, $top ? '-'.$top.$type : null );
        }
        else if('desktopRight' === $deviceAttr ){
            $right = $BoxFourDevices && $BoxFourDevices['desktopRight'] ? $BoxFourDevices['desktopRight'] : 0;
            $css = gutentor_generate_css( $cssAttr, $right ? '-'.$right.$type : null );

        }
        else if('desktopBottom' === $deviceAttr ){
            $bottom = $BoxFourDevices && $BoxFourDevices['desktopBottom'] ? $BoxFourDevices['desktopBottom']: 0;
            $css = gutentor_generate_css( $cssAttr, $bottom ? '-'.$bottom.$type : null );
        }
        else if('desktopLeft' === $deviceAttr ){
            $left = $BoxFourDevices &&  $BoxFourDevices['desktopLeft'] ? $BoxFourDevices['desktopLeft'] : 0;
            $css = gutentor_generate_css( $cssAttr, $left ? '-'.$left.$type : null );
        }
        else if( 'tabletTop' === $deviceAttr ) {
            $top = $BoxFourDevices && $BoxFourDevices['tabletTop'] ? $BoxFourDevices['tabletTop'] : 0;
            $css = gutentor_generate_css( $cssAttr, $top ? '-'.$top.$type : null );
        }
        else if ('tabletRight' === $deviceAttr ) {
            $right = $BoxFourDevices && $BoxFourDevices['tabletRight'] ? $BoxFourDevices['tabletRight'] : 0;
            $css = gutentor_generate_css( $cssAttr, $right ? '-'.$right.$type : null );
        }
        else if ('tabletBottom' === $deviceAttr ) {
            $bottom = $BoxFourDevices && $BoxFourDevices['tabletBottom'] ? $BoxFourDevices['tabletBottom'] : 0;
            $css = gutentor_generate_css($cssAttr, $bottom ? '-'.$bottom . $type : null);
        }
        else if ('tabletLeft' === $deviceAttr ) {
            $left = $BoxFourDevices &&  $BoxFourDevices['tabletLeft'] ? $BoxFourDevices['tabletLeft'] : 0;
            $css = gutentor_generate_css($cssAttr, $left ? '-'.$left . $type : null);

        }
        else if( 'mobileTop' === $deviceAttr ) {
            $top = $BoxFourDevices && $BoxFourDevices['mobileTop'] ? $BoxFourDevices['mobileTop'] : 0;
            $css = gutentor_generate_css( $cssAttr, $top ? '-'.$top.$type : null );
        }
        else if ('mobileRight' === $deviceAttr ) {
            $right = $BoxFourDevices && $BoxFourDevices['mobileRight'] ? $BoxFourDevices['mobileRight'] : 0;
            $css = gutentor_generate_css( $cssAttr, $right ? '-'.$right.$type : null );
        }
        else if ('mobileBottom' === $deviceAttr ) {
            $bottom = $BoxFourDevices && $BoxFourDevices['mobileBottom'] ? $BoxFourDevices['mobileBottom'] : 0;
            $css = gutentor_generate_css($cssAttr, $bottom ? '-'.$bottom . $type : null);
        }
        else if ('mobileLeft' === $deviceAttr ) {
            $left = $BoxFourDevices &&  $BoxFourDevices['mobileLeft'] ? $BoxFourDevices['mobileLeft'] : 0;
            $css = gutentor_generate_css($cssAttr, $left ? '-'.$left . $type : null);

        }
        return $css;
    }

}

/**
 *  GutentorBackgroundImageOptionsCss
 *
 * @since Gutentor 1.0.0
 *
 * @param null
 * @return string
 *
 */
if (!function_exists('GutentorBackgroundImageOptionsCss')) {

    function GutentorBackgroundImageOptionsCss($BackgroundImageVal, $imgBgPropsOnly = false) {
        $css = '';
        if ($BackgroundImageVal === null || empty($BackgroundImageVal)) {
            return $css;
        }
        $backgroundImage      = $BackgroundImageVal['backgroundImage'] ? $BackgroundImageVal['backgroundImage'] : '';
        $backgroundImage_Url  = ($backgroundImage && isset($BackgroundImageVal['backgroundImage']['url']) && $BackgroundImageVal['backgroundImage']['url'] )? $BackgroundImageVal['backgroundImage']['url'] : '';
        $desktopHeight        = $BackgroundImageVal['desktopHeight'] ? $BackgroundImageVal['desktopHeight'] : '';
        $tabletHeight         = $BackgroundImageVal['tabletHeight'] ? $BackgroundImageVal['tabletHeight'] : '';
        $mobileHeight         = $BackgroundImageVal['mobileHeight'] ? $BackgroundImageVal['mobileHeight'] : '';
        $backgroundSize       = $BackgroundImageVal['backgroundSize'] ? $BackgroundImageVal['backgroundSize'] : '';
        $backgroundPosition   = $BackgroundImageVal['backgroundPosition'] ? $BackgroundImageVal['backgroundPosition'] : '';
        $backgroundRepeat     = $BackgroundImageVal['backgroundRepeat'] ? $BackgroundImageVal['backgroundRepeat'] : '';
        $backgroundAttachment = $BackgroundImageVal['backgroundAttachment'] ? $BackgroundImageVal['backgroundAttachment'] : '';

        if (!$imgBgPropsOnly) {

            $css .= gutentor_generate_css('background-image',$backgroundImage ? 'url('.$backgroundImage_Url.')' : null);
            $css .= gutentor_generate_css('height',$mobileHeight ? $mobileHeight.'px' : null);
            $css .= gutentor_generate_css('background-size',$backgroundSize ? $backgroundSize : null);
            $css .= gutentor_generate_css('background-position',$backgroundPosition ? $backgroundPosition : null);
            $css .= gutentor_generate_css('background-repeat',$backgroundRepeat ? $backgroundRepeat : null);
            $css .= gutentor_generate_css('background-attachment',$backgroundAttachment ? $backgroundAttachment : null);
        }
        else{
            $css .= gutentor_generate_css('height',$mobileHeight ? $mobileHeight.'px' : null);
            $css .= gutentor_generate_css('background-size',$backgroundSize ? $backgroundSize : null);
            $css .= gutentor_generate_css('background-position',$backgroundPosition ? $backgroundPosition : null);
            $css .= gutentor_generate_css('background-repeat',$backgroundRepeat ? $backgroundRepeat : null);
            $css .= gutentor_generate_css('background-attachment',$backgroundAttachment ? $backgroundAttachment : null);

        }
        return $css;
    }
}

/**
 *  GutentorBackgroundResponsiveHeight
 *
 * @since Gutentor 1.0.0
 *
 * @param $BackgroundImageVal
 * @param $device
 * @return string
 *
 */
if (!function_exists('GutentorBackgroundResponsiveHeight')) {

    function GutentorBackgroundResponsiveHeight($BackgroundImageVal, $device) {

        if ($BackgroundImageVal === null || empty($BackgroundImageVal)) {
            return '';
        }
        $desktopHeight = ($BackgroundImageVal['desktopHeight']) ? $BackgroundImageVal['desktopHeight'] : '';
        $tabletHeight  = ($BackgroundImageVal['tabletHeight']) ? $BackgroundImageVal['tabletHeight'] : '';
        $mobileHeight  = ($BackgroundImageVal['mobileHeight']) ? $BackgroundImageVal['mobileHeight'] : '';

        if ('mobile' === $device) {
            return gutentor_generate_css('height', $mobileHeight ? $mobileHeight . 'px' : null);
        }
        if ('tablet' === $device) {
            return gutentor_generate_css('height', $tabletHeight ? $tabletHeight . 'px' : null);
        }
        if ('desktop' === $device) {
            return gutentor_generate_css('height', $desktopHeight ? $desktopHeight . 'px' : null);
        }
        return null;

    }
}


/**
 *  GutentorButtonOptionsClasses
 *
 * @since Gutentor 1.0.0
 *
 * @param null
 * @return string
 *
 */
if (!function_exists('GutentorAnimationOptionsDataAttr')) {

    /**
     * Background Classes
     * @param {string} backgroundType - The Background type
     * @return {array} The inline CSS class.
     */
    function GutentorAnimationOptionsDataAttr( $valueAnimation ) {

        if ($valueAnimation === null || empty($valueAnimation)) {
            return false;
        }
        $animation_attr = '';

        $animation = (isset($valueAnimation['Animation']) && $valueAnimation['Animation']) ? $valueAnimation['Animation'] : '';
        if('none' !== $animation) {
            if (!empty($animation)) {
                $animation_class = 'data-wow-animation = "' . $animation . '"';
                $animation_attr      = gutentor_concat_space($animation_attr, $animation_class);
            }
            $delay = (isset($valueAnimation['Delay']) && $valueAnimation['Delay']) ? $valueAnimation['Delay'] : '';
            if (!empty($delay)) {
                $delay_class = 'data-wow-delay = "' . $delay . 's"';
                $animation_attr  = gutentor_concat_space($animation_attr, $delay_class);
            }
            $speed = (isset($valueAnimation['Speed']) && $valueAnimation['Speed']) ? $valueAnimation['Speed'] : '';
            if (!empty($speed)) {
                $speed_class = 'data-wow-speed = "' . $speed . 's"';
                $animation_attr  = gutentor_concat_space($animation_attr, $speed_class);
            }

            $iteration = (isset($valueAnimation['Iteration']) && $valueAnimation['Iteration']) ? $valueAnimation['Iteration'] : '';
            if (!empty($iteration)) {
                $iteration_class = 'data-wow-iteration = "' . $iteration . '"';
                $animation_attr  = gutentor_concat_space($animation_attr, $iteration_class);
            }
        }
        return $animation_attr;

    }
}



/**
 *  Customize Default layout
 *
 * @since Gutentor 1.0.0
 *
 * @param null
 * @return array $cosmoswp_theme_layout
 *
 */
if (!function_exists('gutentor_get_default_options')) :
    function gutentor_get_default_options() {

        $default_theme_options = array(
            'gutentor_map_api' => 'AIzaSyAq-PUmXMM3M2aQnwUslzap0TXaGyZlqZE',
            'gutentor_dynamic_style_location' => 'head',
            'gutentor_header_template' => 0,
            'gutentor_footer_template' => 0,
            'gutentor_font_awesome_version' => 5,
        );

        return apply_filters('gutentor_default_options', $default_theme_options);
    }
    gutentor_get_default_options();
endif;



/**
 * Get options
 *
 * @since Gutentor 1.0.0
 *
 * @param null
 * @return mixed cosmoswp_theme_options
 *
 */
if (!function_exists('gutentor_get_options')) :

    function gutentor_get_options($key = '') {
        if (!empty($key)) {
            $gutentor_default_options = gutentor_get_default_options();
            $gutentor_get_options     = get_option($key, $gutentor_default_options[$key]);
            return $gutentor_get_options;
        }
        return false;
    }
endif;

/**
 * Return "theme support" values from the current theme, if set.
 *
 * @since Gutentor 1.0.0
 *
 * @return boolean
 */
if (!function_exists('gutentor_get_theme_support')) :

	function gutentor_get_theme_support( ) {
		$theme_support = get_theme_support( 'gutentor' );

		return $theme_support;
	}
endif;
