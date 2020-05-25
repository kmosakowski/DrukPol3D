<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Gutentor_Google_Map' ) ) {

	/**
	 * Functions related to Google Map
	 * @package Gutentor
	 * @since 1.0.1
	 *
	 */

	class Gutentor_Google_Map extends Gutentor_Block_Base{

		/**
		 * Name of the block.
		 *
		 * @access protected
		 * @since 1.0.1
		 * @var string
		 */
		protected $block_name = 'google-map';

		/**
		 * Gets an instance of this object.
		 * Prevents duplicate instances which avoid artefacts and improves performance.
		 *
		 * @static
		 * @access public
		 * @since 1.0.1
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
		 * Google Map Attributes Default Value
		 *
		 * @since      1.0.0
		 * @package    Gutentor
		 * @author     Gutentor <info@gutentor.com>
		 */

		public function get_default_values() {
			$google_map_attr = [
				'id'                                       => '',
				'location'                                 => 'La Sagrada Familia, Barcelona, Spain',
				'containerWidth'                           => 'grid-container',
				'latitude'                                 => '41.4036299',
				'longitude'                                => '2.1743558000000576',
				'type'                                     => 'roadmap',
				'zoom'                                     => 15,
				'mapHeight'                                => [
					'type'    => 'px',
					'desktop' => '250',
					'tablet'  => '250',
					'mobile'  => '150',
				],
				'draggable'                                => true,
				'mapTypeControl'                           => true,
				'zoomControl'                              => true,
				'fullscreenControl'                        => true,
				'streetViewControl'                        => true,
				'markers'                                  => [],
			];
			$google_map_attr = apply_filters( 'gutentor_google_map_get_default_values', $google_map_attr );
			return $google_map_attr;
		}

		/**
		 * Returns attributes for this Block
		 *
		 * @static
		 * @access public
		 * @since 1.0.0
		 * @return array
		 */
		protected function get_attrs(){
			$google_map_attr = array(
				'id'				=> array(
					'type'    => 'string',
				),
				'blockID'				=> array(
					'type'    => 'string',
				),
				'gutentorBlockName' => array(
					'type'    => 'string',
				),
				'containerWidth'=> array(
					'type'    => 'string',
					'default' => 'grid-container'
				),
				'location'			=> array(
					'type'    => 'string',
					'default' => 'La Sagrada Familia, Barcelona, Spain',
				),
				'latitude'			=> array(
					'type'    => 'string',
					'default' => '41.4036299',
				),
				'longitude'			=> array(
					'type'    => 'string',
					'default' => '2.1743558000000576',
				),
				'type'				=> array(
					'type'    => 'string',
					'default' => 'roadmap',
				),
				'zoom'				=> array(
					'type'    => 'number',
					'default' => 15,
				),
				'mapHeight' => array(
					'type'    => 'object',
					'default'=> array(
						'type' => 'px',
						'desktop' => '250',
						'tablet'  => '250',
						'mobile'  => '150',
					)
				),
				'draggable'			=> array(
					'type'    => 'boolean',
					'default' => true,
				),
				'mapTypeControl'	=> array(
					'type'    => 'boolean',
					'default' => true,
				),
				'zoomControl'		=> array(
					'type'    => 'boolean',
					'default' => true,
				),
				'fullscreenControl'	=> array(
					'type'    => 'boolean',
					'default' => true,
				),
				'streetViewControl'	=> array(
					'type'    => 'boolean',
					'default' => true,
				),
				'markers'			=> array(
					'type'    => 'object',
					'default' => array(),
				)
			);
			return $google_map_attr;
		}

		/**
		 * Add Dynamic Css
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @param array $data
		 * @param array $attributes
		 * @return array | boolean
		 */
		function add_dynamic_css( $data, $attributes ) {

			if ($attributes['gutentorBlockName'] != 'gutentor/google-map') {
				return $data;
			}

			$google_map_default_val       = $this->get_default_values();
			$attributes                   = wp_parse_args($attributes, $google_map_default_val);
			$local_dynamic_css            = array();
			$local_dynamic_css['all']     = '';
			$local_dynamic_css['tablet']  = '';
			$local_dynamic_css['desktop'] = '';

			/* Map Height*/
			$local_dynamic_css['all']     .= '#' . $attributes['id'] . '{
            ' . gutentor_responsive_height_width('height',$attributes['mapHeight']) . ' 
        }';
			$local_dynamic_css['desktop'] .= '#' . $attributes['id'] . '{
            ' . gutentor_responsive_height_width('height',$attributes['mapHeight'], 'desktop') . ' 
        }';
			$local_dynamic_css['tablet']  .= '#' . $attributes['id'] . '{
            ' . gutentor_responsive_height_width('height',$attributes['mapHeight'], 'tablet') . ' 
        }';

			$output = array_merge_recursive($data, $local_dynamic_css);
			return $output;
		}

		/**
		 * Render Google Map Data
		 *
		 * @since    1.0.1
		 * @access   public
		 *
		 * @param array $attributes
		 * @param string $content
		 * @return string
		 */
		public function render_callback( $attributes, $content ) {
			$google_style = '';
			if(gutentor_get_options('gutentor_dynamic_style_location')){
				$gutentor_dynamic_style_location =  gutentor_get_options('gutentor_dynamic_style_location');
				if('default' == $gutentor_dynamic_style_location){
					$google_style .= $this->get_common_css($attributes);
				}

			}
			$id      = isset($attributes['id']) ? $attributes['id'] : 'gutentor-google-map-' . rand(10, 100);
			$blockID = isset($attributes['blockID']) ? $attributes['blockID'] : '';
			$class   = 'gutentor-google-map';

			if (isset($attributes['className'])) {
				$class .= ' ' . esc_attr($attributes['className']);
			}

			$align = isset($attributes['align']) ? 'align'.$attributes['align'] : '';
			$tag = $attributes['blockSectionHtmlTag'] ? $attributes['blockSectionHtmlTag'] : 'section';

			$blockComponentAnimation = isset($attributes['blockComponentAnimation']) ? $attributes['blockComponentAnimation'] : '';
			$blockItemsWrapAnimation = isset($attributes['blockItemsWrapAnimation']) ? $attributes['blockItemsWrapAnimation'] : '';

			$output         = '<'.$tag.' class="'.apply_filters('gutentor_save_section_class', 'gutentor-section gutentor-google-map '.$align, $attributes).'" id="section-' . esc_attr($blockID) . '"   '.GutentorAnimationOptionsDataAttr($blockComponentAnimation).'>' . "\n";
			$output         .= '<style>'.$google_style.'</style>';
			$output         .= apply_filters( 'gutentor_save_before_container', '', $attributes );
			$output         .= '<div class="grid-container">' . "\n";
			$output         .= apply_filters('gutentor_save_before_block_items', '', $attributes);
			$output         .= '<div class="' . apply_filters('gutentor_save_grid_row_class', gutentor_concat_space(esc_attr($class),'gutentor-grid-item-wrap' ), $attributes). '" id="' . esc_attr($id) . '" '.GutentorAnimationOptionsDataAttr($blockItemsWrapAnimation).'></div>' . "\n";
			$output         .= apply_filters('gutentor_save_after_block_items', '', $attributes);
			$output         .= '</div>' . "\n";
			$output         .= apply_filters( 'gutentor_save_after_container', '', $attributes );
			$output         .= '</'.$tag.'>' . "\n";
			$output         .= '<script type="text/javascript">' . "\n";
			$output         .= '	/* <![CDATA[ */' . "\n";
			$output         .= '		if ( ! window.gutentorGoogleMaps ) window.gutentorGoogleMaps =[];' . "\n";
			$output         .= '		window.gutentorGoogleMaps.push( { container: "' . $id . '", attributes: ' . json_encode($attributes) . ' } );' . "\n";
			$output         .= '	/* ]]> */' . "\n";
			$output         .= '</script>' . "\n";

			return $output;
		}
	}
}
Gutentor_Google_Map::get_instance()->run();