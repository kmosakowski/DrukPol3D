<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Gutentor_Block_Hooks' ) ) {

	/**
	 * Block Specific Hooks Class For Gutentor
	 * @package Gutentor
	 * @since 2.0.0
	 *
	 */
	class Gutentor_Block_Hooks{

		/**
		 * Prevent some functions to called many times
		 * @access private
		 * @since 2.0.0
		 * @var integer
		 */
		private static $counter = 0;

		/**
		 * Gets an instance of this object.
		 * Prevents duplicate instances which avoid artefacts and improves performance.
		 *
		 * @static
		 * @access public
		 * @since 2.0.0
		 * @return object
		 */
		public static function get_instance() {

			// Store the instance locally to avoid private static replication
			static $instance = null;

			// Only run these methods if they haven't been ran previously
			if ( null === $instance ) {
				$instance = new self();
			}

			// Always return the instance
			return $instance;

		}
		
        /**
         * Add Filter
         *
         * @access public
         * @since 2.0.0
         * @return void
         */
		public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ){
            add_filter( $hook, array( $component, $callback ), $priority, $accepted_args );
        }

        /**
         * Add Action
         *
         * @access public
         * @since 2.0.0
         * @return void
         */
        public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ){
            add_action( $hook, array( $component, $callback ), $priority, $accepted_args );
        }


        /**
		 * Run Block
		 *
		 * @access public
		 * @since 2.0.0
		 * @return void
		 */
		public function run(){
            /*Block Specific PHP hooks*/
            $this->add_filter( 'gutentor_save_section_class', $this, 'add_section_classes',10,2);
            $this->add_filter( 'gutentor_save_section_class', $this, 'add_animation_class',15,2);
            $this->add_filter( 'gutentor_save_before_block_items', $this, 'addAdvancedBlockShapeTop',15,2);
            $this->add_filter( 'gutentor_save_after_block_items', $this, 'addAdvancedBlockShapeBottom',15,2);
            $this->add_filter( 'gutentor_save_grid_row_class', $this, 'add_Item_wrap_animation_class',15,2);
            $this->add_filter( 'gutentor_save_item_image_display_data', $this, 'add_link_to_post_thumbnails',15,3);
            $this->add_filter( 'gutentor_save_grid_column_class', $this, 'add_column_class',10,2);
            $this->add_filter( 'gutentor_save_before_block_items', $this, 'add_block_save_header',10,2);
            $this->add_filter( 'gutentor_save_link_attr', $this, 'addButtonLinkAttr',10,3);
            $this->add_filter( 'gutentor_save_block_header_data', $this, 'gutentor_heading_title',10,2);
            $this->add_filter( 'gutentor_save_grid_column_class', $this, 'addingBlogStyleOptionsClass',15,2);
            $this->add_filter( 'gutentor_edit_enable_column', $this, 'remove_column_class_blog_post',8,2);


            /*Get dynamic CSS location*/
            $this->add_filter( 'gutentor_dynamic_style_location', $this, 'get_dynamic_style_location' );

            /*Block dynamic CSS*/
            $this->add_filter( 'gutentor_dynamic_css', $this, 'image_option_css', 20, 2 );
            $this->add_filter( 'gutentor_dynamic_css', $this, 'repeater_item_css', 20, 2 );

            /*Header and Footer Template*/
            $this->add_action( 'gutentor_header', $this, 'gutentor_header' );
            $this->add_action( 'gutentor_footer', $this, 'gutentor_footer' );
		}

        /**
         * Adding Section Classes
         *
         * @param {array} output
         * @param {object} props
         * @return {array}
         */
        public function add_section_classes( $output, $attributes ){

            $local_data                  = '';
            $blockComponentBGType        = (isset($attributes['blockComponentBGType'])) ? $attributes['blockComponentBGType'] : '';
            $blockComponentEnableOverlay = (isset($attributes['blockComponentEnableOverlay'])) ? $attributes['blockComponentEnableOverlay'] : '';

            /* Bg classes */
            $bg_class   = GutentorBackgroundOptionsCSSClasses($blockComponentBGType);
            $local_data = gutentor_concat_space($local_data, $bg_class);

            /*Overlay classes*/
            $overlay    = $blockComponentEnableOverlay ? 'has-gutentor-overlay' : '';
            $local_data = gutentor_concat_space($local_data, $overlay);

            /*Shape Top select classes*/
            $blockShapeTopSelect      = ($attributes['blockShapeTopSelect']) ? $attributes['blockShapeTopSelect'] : false;
            $blockShapeTopSelectClass = $blockShapeTopSelect ? 'has-gutentor-block-shape-top' : '';
            $local_data               = gutentor_concat_space($local_data, $blockShapeTopSelectClass);

            /*Shape Bottom select classes*/
            $blockShapeBottomSelect      = ($attributes['blockShapeBottomSelect']) ? $attributes['blockShapeBottomSelect'] : false;
            $blockShapeBottomSelectClass = $blockShapeBottomSelect ? 'has-gutentor-block-shape-bottom' : '';
            $local_data                  = gutentor_concat_space($local_data, $blockShapeBottomSelectClass);

            $local_data = gutentor_concat_space($output, $local_data);

            return $local_data;

        }

        /**
         * Adding Section Animation Class
         *
         * @param {array} output
         * @param {object} props
         * @return {array}
         */
        public function add_animation_class($output, $attributes) {

            $blockComponentAnimation =  $attributes['blockComponentAnimation'] ? $attributes['blockComponentAnimation'] : '';
            $animation_class = ($blockComponentAnimation && $attributes['blockComponentAnimation']['Animation'] && 'none' != $attributes['blockComponentAnimation']['Animation']) ? gutentor_concat_space('wow animated ', $attributes['blockComponentAnimation']['Animation']): '';
            return gutentor_concat_space($output, $animation_class);
        }

        /**
         * Advanced Block Shape Before Container
         * @param {string} $output
         * @return {object} $attributes
         */
        public function addAdvancedBlockShapeTop($output, $attributes) {

            $blockShapeTopSelect = ($attributes['blockShapeTopSelect']) ? $attributes['blockShapeTopSelect'] : false;
            if (!$blockShapeTopSelect) {
                return $output;
            }
            $shape_data = '<div class="gutentor-block-shape-top"><span>' . $blockShapeTopSelect . '</span></div>';
            return $output.$shape_data;
        }

        /**
         * Advanced Block Shape Before Container
         * @param {string} $output
         * @return {object} $attributes
         */
        public function addAdvancedBlockShapeBottom($output, $attributes) {

            $blockShapeBottomSelect = ($attributes['blockShapeBottomSelect']) ? $attributes['blockShapeBottomSelect'] : false;
            if (!$blockShapeBottomSelect) {
                return $output;
            }
            $shape_data = '<div class="gutentor-block-shape-bottom"><span>' . $blockShapeBottomSelect . '</span></div>';
            return $output.$shape_data;
        }

        /**
         * Adding Item Wrap Animation Class
         *
         * @param {array} output
         * @param {object} props
         * @return {array}
         */
        public function add_Item_wrap_animation_class($output, $attributes) {

            $blockItemsWrapAnimation = isset($attributes['blockItemsWrapAnimation']) ? $attributes['blockItemsWrapAnimation'] : '';
            $animation_class = ($blockItemsWrapAnimation && $attributes['blockItemsWrapAnimation']['Animation'] && 'none' != $attributes['blockItemsWrapAnimation']['Animation']) ? gutentor_concat_space('wow animated ', $attributes['blockItemsWrapAnimation']['Animation']): '';
            return gutentor_concat_space($output, $animation_class);
        }

        /**
         * Adding Link to Post Thumbnails
         *
         * @param {array} output
         * @param {object} props
         * @return {array}
         */
        public function add_link_to_post_thumbnails($output,$url, $attributes) {
            $output_wrap = '';
            $target = '';
            if(empty($output) || $output == null){
                return $output;
            }
            if(!$attributes['gutentorBlogPostImageLink']){
                return $output;
            }
            if($attributes['gutentorBlogPostImageLinkNewTab']){
                $target = 'target="_blank"';
            }
            $output_wrap .= '<a class="gutentor-single-item-image-link" href="'.$url.'" '.$target.'>';
            $output_wrap .= $output;
            $output_wrap .= '</a>';
            return $output_wrap;

        }

        /**
         * Adding Block Header
         *
         * @param {array} output
         * @param {object} props
         * @return {array}
         */
        public function add_column_class( $output, $attributes ){

            if(!apply_filters('gutentor_edit_enable_column',true, $attributes ) ){
                return $output;
            }
            $local_data               = '';
            $blockItemsColumn_desktop = (isset($attributes['blockItemsColumn']['desktop'])) ? $attributes['blockItemsColumn']['desktop'] : '';
            $local_data               = gutentor_concat_space($local_data, $blockItemsColumn_desktop);
            $blockItemsColumn_tablet  = (isset($attributes['blockItemsColumn']['tablet'])) ? $attributes['blockItemsColumn']['tablet'] : '';
            $local_data               = gutentor_concat_space($local_data, $blockItemsColumn_tablet);
            $blockItemsColumn_mobile  = (isset($attributes['blockItemsColumn']['mobile'])) ? $attributes['blockItemsColumn']['mobile'] : '';
            $local_data               = gutentor_concat_space($local_data, $blockItemsColumn_mobile);
            return gutentor_concat_space($output, $local_data);
        }

        /**
         * Adding Block Header
         *
         * @param {array} output
         * @param {object} props
         * @return {array}
         */
        public function add_block_save_header( $output, $attributes ){

            if(!apply_filters('gutentor_save_block_header_data_enable',true,$attributes)){
                return $output;
            }
            $blockHeader  = '';
            $blockHeader = '<div class="'.apply_filters('gutentor_save_block_header_class', 'gutentor-block-header', $attributes).'">';
            $blockHeader .= apply_filters( 'gutentor_save_block_header_data','', $attributes  );
            $blockHeader .= '</div>';
            return $output.$blockHeader;
        }

        /**
         * Add Button Attributes
         *
         * @param {object} output
         * @param {string} buttonLink
         * @param {object} buttonLinkOptions
         * @return {object}
         */
        public function addButtonLinkAttr( $output,$buttonLink, $buttonLinkOptions ){

            $target     = $buttonLinkOptions['openInNewTab'] ? '_blank' : '';
            $rel        = ($buttonLinkOptions['rel']) ? $buttonLinkOptions['rel'] : '';
            $a_href     = ($buttonLink) ? 'href="' . $buttonLink . '"' : '';
            $a_target   = ($target) ? 'target="' . $target . '" ' : '';
            $local_data = gutentor_concat_space($a_href, $a_target);
            $a_rel      = ($rel) ? 'rel="' . $rel . '" ' : '';
            $local_data = gutentor_concat_space($local_data, $a_rel);
            return gutentor_concat_space($output, $local_data);
        }

        /**
         * Callback functions for body_class,
         * Adding Admin Body Class.
         *
         * @since    1.0.0
         * @access   public
         *
         * @param string $classes
         * @return string
         */
        public function gutentor_heading_title( $data,$attributes ){

            $output                        = '';
            $block_title_tag               = '';
            $block_title                   = '';
            $section_title_align           = '';
            $section_title_animation       = '';
            $section_title_animation_class = '';
            $block_enable_design_title     = '';
            $block_design_title            = '';
            if ( isset( $attributes['blockComponentTitleAlign'] ) ) {
                $section_title_align =  ($attributes['blockComponentTitleAlign']) ? $attributes['blockComponentTitleAlign'] : '';
            }
            if ( isset( $attributes['blockComponentTitleAnimation'] ) ) {
                $section_title_animation =  ($attributes['blockComponentTitleAnimation']) ? $attributes['blockComponentTitleAnimation'] : '';
                $section_title_animation_class =  ($attributes['blockComponentTitleAnimation']['Animation'] && 'none' != $attributes['blockComponentTitleAnimation']['Animation']) ? 'wow animated '.$attributes['blockComponentTitleAnimation']['Animation'] : '';
            }
            if ( isset( $attributes['blockComponentTitleTag'] ) ) {
                $block_title_tag =  ($attributes['blockComponentTitleTag']) ? $attributes['blockComponentTitleTag'] : '';
            }
            if ( isset( $attributes['blockComponentTitle'] ) ) {
                $block_title =  ($attributes['blockComponentTitle']) ? $attributes['blockComponentTitle'] : '';
            }
            if ( isset( $attributes['blockComponentTitleDesignEnable'] )) {
                $block_enable_design_title =  ($attributes['blockComponentTitleDesignEnable']) ? 'enable-title-design' : '';
            }
            if ( isset( $attributes['blockComponentTitleDesignEnable'] ) && isset( $attributes['blockComponentTitleSeperatorPosition'] )) {
                $block_design_title =  ($attributes['blockComponentTitleDesignEnable'] && $attributes['blockComponentTitleSeperatorPosition']) ? $attributes['blockComponentTitleSeperatorPosition'] : 'seperator-bottom';
            }

            $blockComponentTitleEnable = isset($attributes['blockComponentTitleEnable']) ? $attributes['blockComponentTitleEnable'] : false;
            if( $blockComponentTitleEnable ) {
                $output .= '<div class="gutentor-section-title '.gutentor_concat_space($block_enable_design_title,$block_design_title).' '.gutentor_concat_space($section_title_align,$section_title_animation_class). ' "  '.GutentorAnimationOptionsDataAttr($section_title_animation).'>' . "\n";
                $output .= '<'.$block_title_tag.' class="gutentor-title">' . "\n";
                $output .=  $block_title;
                $output .= '</'.$block_title_tag.'>' . "\n";
                $output .= '</div>' . "\n";
            }
            return $data.$output;
        }

        /**
         * Adding Class
         *
         * @param {array} output
         * @param {object} props
         * @return {array}
         */
        public function addingBlogStyleOptionsClass( $output, $attributes ){


            if( 'gutentor/blog-post' !== $attributes['gutentorBlockName']){
                return $output;
            }
            $blog_style_class =  $attributes['blockBlogStyle'] ? $attributes['blockBlogStyle'] : '';
            return gutentor_concat_space($output, $blog_style_class);
        }

        /**
         * Remove Column Class in Blog post
         *
         * @param {array} output
         * @param {object} attributes
         * @return string
         */
        public function remove_column_class_blog_post($output, $attributes) {

            if ('gutentor/blog-post' !== $attributes['gutentorBlockName']) {
                return $output;
            }
            if ($attributes['blockBlogStyle'] === 'blog-list') {
                return false;
            }
            return $output;
        }

        /**
         * Get value of gutentor_dynamic_style_location
         *
         * @param {string} $gutentor_dynamic_style_location
         * @return string
         */
        public function get_dynamic_style_location( $gutentor_dynamic_style_location ){
            if ( gutentor_get_options( 'gutentor_dynamic_style_location' ) ) {
                $gutentor_dynamic_style_location =  gutentor_get_options('gutentor_dynamic_style_location');
            }
            return $gutentor_dynamic_style_location;
        }

        /**
         * Image Option css
         *
         * @since    1.0.0
         * @access   public
         *
         * @param array $data
         * @param array $attributes
         * @return array | boolean
         */
        public function image_option_css($data,$attributes) {

            $block_list = array('gutentor/blog-post');
            $block_list = apply_filters('gutentor_image_option_css_access_block',$block_list);
            if(!in_array($attributes['gutentorBlockName'] , $block_list)){
                return $data;
            }
            $local_dynamic_css            = array();
            $local_dynamic_css['all']     = '';
            $local_dynamic_css['tablet']  = '';
            $local_dynamic_css['desktop'] = '';

            /*Image overlay css*/
            $img_overlay_color_enable = $attributes['blockImageBoxImageOverlayColor']['enable'] ? $attributes['blockImageBoxImageOverlayColor']['enable'] : '';
            $img_overlay_color_normal = ($attributes['blockImageBoxImageOverlayColor'] && $attributes['blockImageBoxImageOverlayColor']['normal'] && isset($attributes['blockImageBoxImageOverlayColor']['normal']['rgb'])) ? gutentor_rgb_string($attributes['blockImageBoxImageOverlayColor']['normal']['rgb']) : '';
            $img_overlay_color_hover = ($attributes['blockImageBoxImageOverlayColor'] && $attributes['blockImageBoxImageOverlayColor']['hover'] && isset($attributes['blockImageBoxImageOverlayColor']['hover']['rgb'])) ? gutentor_rgb_string($attributes['blockImageBoxImageOverlayColor']['hover']['rgb']) : '';

            $local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-image-box .overlay{
                    '.gutentor_generate_css('background',($img_overlay_color_enable && $img_overlay_color_normal) ? $img_overlay_color_normal : null ) . '
            }';
            $local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item:hover .gutentor-single-item-image-box .overlay{
                    '.gutentor_generate_css('background',($img_overlay_color_enable && $img_overlay_color_hover) ? $img_overlay_color_hover : null ) . '
            }';
            $blockFullImageEnable      = (isset($attributes['blockFullImageEnable']) && $attributes['blockFullImageEnable']) ? $attributes['blockFullImageEnable'] : '';
            $blockSingleItemBoxPadding = (isset($attributes['blockSingleItemBoxPadding']) && $attributes['blockSingleItemBoxPadding']) ? $attributes['blockSingleItemBoxPadding'] : '';
            $blockImageBoxMargin       = isset($attributes['blockImageBoxMargin']) ? $attributes['blockImageBoxMargin'] : '';
            $blockImageBoxPadding      = isset($attributes['blockImageBoxPadding']) ? $attributes['blockImageBoxPadding'] : '';
            if($blockFullImageEnable){
                $local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-image-box{
	                '.GutentorBoxSingleDeviceNegativeSpacing( 'margin-top', $blockSingleItemBoxPadding, 'mobileTop' ). '
	                '.GutentorBoxSingleDeviceNegativeSpacing( 'margin-right', $blockSingleItemBoxPadding, 'mobileRight' ). '
	                '.GutentorBoxSingleDeviceNegativeSpacing( 'margin-left', $blockSingleItemBoxPadding, 'mobileLeft' ). '
	            }';

                $local_dynamic_css['tablet'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-image-box{
	                '. GutentorBoxSingleDeviceNegativeSpacing( 'margin-top', $blockSingleItemBoxPadding, 'tabletTop' ). '
	                '. GutentorBoxSingleDeviceNegativeSpacing( 'margin-right', $blockSingleItemBoxPadding, 'tabletRight' ). '
	                '. GutentorBoxSingleDeviceNegativeSpacing( 'margin-left', $blockSingleItemBoxPadding, 'tabletLeft' ). '
	            }';

                $local_dynamic_css['desktop'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-image-box{
	                '. GutentorBoxSingleDeviceNegativeSpacing( 'margin-top', $blockSingleItemBoxPadding, 'desktopTop' ). '
	                '. GutentorBoxSingleDeviceNegativeSpacing( 'margin-right', $blockSingleItemBoxPadding, 'desktopRight' ). '
	                '. GutentorBoxSingleDeviceNegativeSpacing( 'margin-left', $blockSingleItemBoxPadding, 'desktopLeft' ). '
	            }';
            }
            $local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-image-box{
                ' . gutentor_box_four_device_options_css('margin', $blockImageBoxMargin) . '
                ' . gutentor_box_four_device_options_css('padding', $blockImageBoxPadding) . '
        }';

            $local_dynamic_css['tablet'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-image-box{
                ' . gutentor_box_four_device_options_css('margin', $blockImageBoxMargin, 'tablet') . '
                ' . gutentor_box_four_device_options_css('padding', $blockImageBoxPadding, 'tablet') . ' 
        }';

            $local_dynamic_css['desktop'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-image-box{
                ' . gutentor_box_four_device_options_css('margin', $blockImageBoxMargin, 'desktop') . '
                ' . gutentor_box_four_device_options_css('padding', $blockImageBoxPadding, 'desktop') . '
        }';
            $output = array_merge_recursive($data, $local_dynamic_css);
            return $output;
        }

        /**
         * Repeater Item css
         * repeater_item_css
         *
         * @since    1.0.0
         * @access   public
         *
         * @param array $data
         * @param array $attributes
         * @return array | boolean
         */
        public function repeater_item_css( $data, $attributes ) {

            $block_list = array('gutentor/blog-post');
            $block_list = apply_filters('gutentor_repeater_style_access_block',$block_list);

            $attr_default_val       = gutentor_block_base()->get_single_item_common_attrs_default_values();
            $attributes             = wp_parse_args($attributes, $attr_default_val);

            if(!in_array($attributes['gutentorBlockName'] , $block_list)){
                return $data;
            }
            $local_dynamic_css            = array();
            $local_dynamic_css['all']     = '';
            $local_dynamic_css['tablet']  = '';
            $local_dynamic_css['desktop'] = '';

            /*Single Item Title */
            if($attributes['blockSingleItemTitleEnable']) {
                $title_color_enable = ($attributes['blockSingleItemTitleColor']['enable']) ? $attributes['blockSingleItemTitleColor']['enable'] : '';
                $title_margin       = isset($attributes['blockSingleItemTitleMargin']) ? $attributes['blockSingleItemTitleMargin'] : '';
                $title_padding      = isset($attributes['blockSingleItemTitlePadding']) ? $attributes['blockSingleItemTitlePadding'] : '';
                $title_typography   = isset($attributes['blockSingleItemTitleTypography']) ? $attributes['blockSingleItemTitleTypography'] : '';
                $local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-title,
             #section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-title a{
                     ' . gutentor_generate_css('color', ($title_color_enable && $attributes['blockSingleItemTitleColor']['normal']) ? $attributes['blockSingleItemTitleColor']['normal']['hex'] : null) . '
                     ' . gutentor_typography_options_css($title_typography) . '
                     ' . gutentor_box_four_device_options_css('margin', $title_margin). '
                     ' . gutentor_box_four_device_options_css('padding', $title_padding) . '
            }';

                $local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item:hover .gutentor-single-item-title,
             #section-' . $attributes['blockID'] . ' .gutentor-single-item:hover .gutentor-single-item-title a{
                     ' . gutentor_generate_css('color', ($title_color_enable && $attributes['blockSingleItemTitleColor']['hover']) ? $attributes['blockSingleItemTitleColor']['hover']['hex'] : null) . '
            }';

                $local_dynamic_css['tablet'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-title,
            #section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-title a{
                 ' . gutentor_typography_options_responsive_css($title_typography, 'tablet') . '
                 ' . gutentor_box_four_device_options_css('margin', $title_margin, 'tablet') . '
                 ' . gutentor_box_four_device_options_css('padding', $title_padding, 'tablet') . '
            }';

                $local_dynamic_css['desktop'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-title,
            #section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-title a{
                 ' . gutentor_typography_options_responsive_css($title_typography, 'desktop') . '
                 ' . gutentor_box_four_device_options_css('margin', $title_margin, 'desktop') . '
                 ' . gutentor_box_four_device_options_css('padding', $title_padding, 'desktop') . '
            }';
            }

            /*Single Item Desc */
            if($attributes['blockSingleItemDescriptionEnable']) {
                $desc_color_enable = $attributes['blockSingleItemDescriptionColor']['enable'] ? $attributes['blockSingleItemDescriptionColor']['enable'] : '';
                $desc_margin       = isset($attributes['blockSingleItemDescriptionMargin']) ? $attributes['blockSingleItemDescriptionMargin'] : '';
                $desc_padding      = isset($attributes['blockSingleItemDescriptionPadding']) ? $attributes['blockSingleItemDescriptionPadding'] : '';
                $desc_typography   = isset($attributes['blockSingleItemDescriptionTypography']) ? $attributes['blockSingleItemDescriptionTypography'] : '';

                $local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-desc{
             ' . gutentor_generate_css('color', ($desc_color_enable && $attributes['blockSingleItemDescriptionColor']['normal']) ? $attributes['blockSingleItemDescriptionColor']['normal']['hex'] : null) . '
             ' . gutentor_typography_options_css($desc_typography) . '
             ' . gutentor_box_four_device_options_css('margin', $desc_margin) . '
             ' . gutentor_box_four_device_options_css('padding', $desc_padding) . '
            }';

                $local_dynamic_css['all']     .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item:hover .gutentor-single-item-desc{
                ' . gutentor_generate_css('color', ($desc_color_enable && $attributes['blockSingleItemDescriptionColor']['hover']) ? $attributes['blockSingleItemDescriptionColor']['hover']['hex'] : null) . '
            }';
                $local_dynamic_css['tablet']  .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-desc{
                  ' . gutentor_typography_options_responsive_css($desc_typography, 'tablet') . '
                  ' . gutentor_box_four_device_options_css('margin', $desc_margin, 'tablet') . '
                  ' . gutentor_box_four_device_options_css('padding', $desc_padding, 'tablet') . '
            }';
                $local_dynamic_css['desktop'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-desc{
                  ' . gutentor_typography_options_responsive_css($desc_typography, 'desktop') . '
                  ' . gutentor_box_four_device_options_css('margin', $desc_margin, 'desktop') . '
                  ' . gutentor_box_four_device_options_css('padding', $desc_padding, 'desktop') . '
            }';
            }

            /*single Item Button*/
            $button_css                      = array();
            if($attributes['blockSingleItemButtonEnable']){
                $button                      = array();
                $button['blockID']           = $attributes['blockID'];
                $button['buttonColor']       = $attributes['blockSingleItemButtonColor'];
                $button['buttonTextColor']   = $attributes['blockSingleItemButtonTextColor'];
                $button['buttonMargin']      = $attributes['blockSingleItemButtonMargin'];
                $button['buttonPadding']     = $attributes['blockSingleItemButtonPadding'];
                $button['buttonIconOptions'] = $attributes['blockSingleItemButtonIconOptions'];
                $button['buttonIconMargin']  = $attributes['blockSingleItemButtonIconMargin'];
                $button['buttonIconPadding'] = $attributes['blockSingleItemButtonIconPadding'];
                $button['buttonBorder']      = $attributes['blockSingleItemButtonBorder'];
                $button['buttonBoxShadow']   = $attributes['blockSingleItemButtonBoxShadow'];
                $button['buttonTypography']  = $attributes['blockSingleItemButtonTypography'];
                $button['buttonClass']       = 'gutentor-single-item-button';
                $button_css                  = GutentorButtonCss($button);

            }
            /* Single Item Box padding/margin */
            $single_item_Box_margin  = isset($attributes['blockSingleItemBoxMargin']) ? $attributes['blockSingleItemBoxMargin'] : '';
            $single_item_Box_padding = isset($attributes['blockSingleItemBoxPadding']) ? $attributes['blockSingleItemBoxPadding'] : '';
            $single_item_box_border = isset($attributes['blockSingleItemBoxBorder']) ? $attributes['blockSingleItemBoxBorder'] : '';
            $single_item_box_shadow = isset($attributes['blockSingleItemBoxShadowOptions']) ? $attributes['blockSingleItemBoxShadowOptions'] : '';
            $single_item_BoxBg_Enable   = isset($attributes['blockSingleItemBoxColor']['enable']) ? $attributes['blockSingleItemBoxColor']['enable'] : '';
            $single_item_BoxBg_color   = isset($attributes['blockSingleItemBoxColor']['normal']) ? $attributes['blockSingleItemBoxColor']['normal'] : '';

            $local_dynamic_css['all']     .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item{
            ' . gutentor_generate_css('background', ($single_item_BoxBg_Enable && $single_item_BoxBg_color && isset($attributes['blockSingleItemBoxColor']['normal']['rgb'])) ? gutentor_rgb_string($attributes['blockSingleItemBoxColor']['normal']['rgb']) : null) . '
            ' . gutentor_box_four_device_options_css('margin', $single_item_Box_margin) . '
            ' . gutentor_box_four_device_options_css('padding', $single_item_Box_padding) . '
            '.gutentor_border_css($single_item_box_border).'
            '.gutentor_border_shadow_css($single_item_box_shadow).'
        }';

            $local_dynamic_css['all']     .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item:hover{
            ' . gutentor_generate_css('background', ($single_item_BoxBg_Enable && $single_item_BoxBg_color && isset($attributes['blockSingleItemBoxColor']['hover']['rgb'])) ? gutentor_rgb_string($attributes['blockSingleItemBoxColor']['hover']['rgb']) : null) . '
        }';

            $local_dynamic_css['tablet']  .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item{
            ' . gutentor_box_four_device_options_css('margin', $single_item_Box_margin, 'tablet') . '
            ' . gutentor_box_four_device_options_css('padding', $single_item_Box_padding, 'tablet') . '
        }';

            $local_dynamic_css['desktop'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item{
            ' . gutentor_box_four_device_options_css('margin', $single_item_Box_margin, 'desktop') . '
            ' . gutentor_box_four_device_options_css('padding', $single_item_Box_padding, 'desktop') . '
        }';

            $output = array_merge_recursive($data, $local_dynamic_css);
            $output = array_merge_recursive($output, $button_css);
            return $output;
        }

        /**
         * Header Template
         * @param {string} $templates
         * @return mixed
         */
        public function gutentor_header () {
            if( !gutentor_get_theme_support()){
                return false;
            }
            if ( !gutentor_get_options( 'gutentor_header_template' ) ) {
                return false;

            }

            $args = array(
                'p' => absint(gutentor_get_options( 'gutentor_header_template' )),
                'post_type'      => 'wp_block',
            );
            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {
                echo "<div id='gutentor-site-header'>";
                while ( $query->have_posts() ) {
                    $query->the_post();
                    the_content();
                }

                wp_reset_postdata();
            }
        }

        /**
         * Footer Template
         * @param {string} $templates
         * @return mixed
         */
        public function gutentor_footer () {
            if( !gutentor_get_theme_support()){
                return false;
            }
            if ( !gutentor_get_options( 'gutentor_footer_template' ) ) {
                return false;

            }

            $args = array(
                'p' => absint(gutentor_get_options( 'gutentor_footer_template' )),
                'post_type'      => 'wp_block',
            );
            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {
                echo "<div id='gutentor-site-footer'>";
                while ( $query->have_posts() ) {
                    $query->the_post();
                    the_content();
                }
                wp_reset_postdata();
            }
        }
		
	}
}

/**
 * Return instance of  Gutentor_Block_Hooks class
 *
 * @since    1.0.0
 */
if( !function_exists( 'gutentor_block_hooks')){

	function gutentor_block_hooks() {

		//return Gutentor_Block_Hooks::get_instance();
		return Gutentor_Block_Hooks::get_instance()->run();
	}
}
gutentor_block_hooks();