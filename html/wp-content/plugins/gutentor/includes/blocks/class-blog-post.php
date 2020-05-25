<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Gutentor_Blog_Post' ) ) {

	/**
	 * Functions related to Blog Post
	 * @package Gutentor
	 * @since 1.0.1
	 *
	 */

	class Gutentor_Blog_Post extends Gutentor_Block_Base{

		/**
		 * Name of the block.
		 *
		 * @access protected
		 * @since 1.0.1
		 * @var string
		 */
		protected $block_name = 'blog-post';

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
		 * Load Dependencies
		 * Used for blog template loading
		 *
		 * @since      1.0.1
		 * @package    Gutentor
		 * @author     Gutentor <info@gutentor.com>
		 */
		public function load_dependencies(){

			require_once GUTENTOR_PATH . 'includes/block-templates/class-blog-post-templates.php';
		}

        /**
         * Returns attributes for this Block
         *
         * @static
         * @access public
         * @since 1.0.1
         * @return array
         */
        protected function get_attrs(){
            $blog_post_attr = array(
                'blockID'   => array(
                    'type'    => 'string',
                    'default' => ''
                ),
                'timestamp'                 => array(
                    'type'    => 'number',
                    'default' => 0
                ),
                'gutentorBlockName' => array(
                    'type'    => 'string',
                ),
                /*blog specific*/
                'blockBlogTemplate'                  => array(
                    'type'    => "string",
                    'default' => "blog-template1"
                ),
                'blockBlogStyle'                  => array(
                    'type'    => "string",
                    'default' => "blog-grid"
                ),
                'postsToShow'               => array(
                    'type'    => 'number',
                    'default' => 6
                ),
                'entryMetaFontSize'               => array(
                    'type'    => 'number',
                    'default' => 14
                ),
                'order'                     => array(
                    'type'    => 'string',
                    'default' => 'desc',
                ),
                'orderBy'                   => array(
                    'type'    => 'string',
                    'default' => 'date',
                ),
                'categories'                => array(
                    'type'    => 'string',
                    'default' => '',
                ),
                'gutentorBlogPostImageLink'=> array(
                    'type'    => 'boolean',
                    'default'    => false,
                ),
                'gutentorBlogPostImageLinkNewTab'=> array(
                    'type'    => 'boolean',
                    'default'    => false,
                ),
                'enablePostImage'           => array(
                    'type'    => 'boolean',
                    'default' => true
                ),
                'enablePostTitle'           => array(
                    'type'    => 'boolean',
                    'default' => true
                ),
                'enablePostAuthor'          => array(
                    'type'    => 'boolean',
                    'default' => true
                ),
                'enablePostDate'            => array(
                    'type'    => 'boolean',
                    'default' => true
                ),
                'enablePostCategory'            => array(
                    'type'    => 'boolean',
                    'default' => true
                ),
                'enablePostExcerpt'         => array(
                    'type'    => 'boolean',
                    'default' => true
                ),
                'excerptLength'         => array(
                    'type'    => 'number',
                    'default' => 100
                ),
                'enableButton'              => array(
                    'type'    => 'boolean',
                    'default' => true
                ),
                'buttonIcon'                => array(
                    'type'    => 'object',
                    'default' => array(
                        'label' => 'fa-book',
                        'value' => 'fas fa-book',
                        'code'  => 'f108'
                    )
                ),
                'buttonText'                => array(
                    'type'    => 'string',
                    'default' => __('Read More')
                ),

                'imageDisplayOptions'       => array(
                    'type'    => 'string',
                    'default' => 'normal-image'
                ),
                'bgImageOptions'            => array(
                    'type'    => "object",
                    'default' => array(
                        'backgroundImage'      => '',
                        'height'               => array(
                            'desktop' => 50,
                            'tablet'  => 50,
                            'mobile'  => 50
                        ),
                        'backgroundSize'       => '',
                        'backgroundPosition'   => '',
                        'backgroundRepeat'     => '',
                        'backgroundAttachment' => '',
                    )
                ),
                'imageBorder'               => array(
                    'type'    => "object",
                    'default' => array(
                        'borderStyle'        => 'none',
                        'borderTop'          => '',
                        'borderRight'        => '',
                        'borderBottom'       => '',
                        'borderLeft'         => '',
                        'borderColor'        => '',
                        'borderRadiusType'   => 'px',
                        'borderRadiusTop'    => '',
                        'borderRadiusRight'  => '',
                        'borderRadiusBottom' => '',
                        'borderRadiusLeft'   => ''
                    )
                ),
                'imageOverlayColor'         => array(
                    'type'    => "object",
                    'default' => array(
                        'enable' => false,
                        'normal' => '',
                        'hover'  => '',
                    )
                ),
                'entryMetaColor'              => array(
                    'type'    => "object",
                    'default' => array(
                        'enable' => false,
                        'normal' => '',
                        'hover'  => '',
                    )
                ),
                'blockEntryMetaTypography'  => array(
                    'type'    => 'object',
                    'default' => array(
                        'fontType'       => '',
                        'systemFont'     => '',
                        'googleFont'     => '',
                        'customFont'     => '',
                        'fontSize'       => array(
                            'desktop' => '',
                            'tablet'  => '',
                            'mobile'  => '',
                        ),
                        'fontWeight'     => '',
                        'textTransform'  => '',
                        'fontStyle'      => '',
                        'textDecoration' => '',
                        'lineHeight'     => array(
                            'desktop' => '',
                            'tablet'  => '',
                            'mobile'  => '',
                        ),
                        'letterSpacing'  => array(
                            'desktop' => '',
                            'tablet'  => '',
                            'mobile'  => '',
                        ),
                    )
                ),
                'blockEntryMetaMargin' => array(
                    'type' => 'object',
                    'default' => array(
                        'type'          => 'px',
                        'desktopTop'    => '',
                        'desktopRight'  => '',
                        'desktopBottom' => '',
                        'desktopLeft'   => '',

                        'tabletTop'    => '',
                        'tabletRight'  => '',
                        'tabletBottom' => '',
                        'tabletLeft'   => '',

                        'mobileTop'    => '',
                        'mobileRight'  => '',
                        'mobileBottom' => '',
                        'mobileLeft'   => '',

                    )
                ),
                'blockEntryMetaPadding' => array(
                    'type' => 'object',
                    'default' => array(
                        'type'          => 'px',
                        'desktopTop'    => '',
                        'desktopRight'  => '',
                        'desktopBottom' => '',
                        'desktopLeft'   => '',

                        'tabletTop'    => '',
                        'tabletRight'  => '',
                        'tabletBottom' => '',
                        'tabletLeft'   => '',

                        'mobileTop'    => '',
                        'mobileRight'  => '',
                        'mobileBottom' => '',
                        'mobileLeft'   => '',
                    )
                ),
            );
            return array_merge_recursive( $blog_post_attr, $this->get_single_item_common_attrs() );
        }
		/**
		 * Blog Post Attributes Default Values
		 *
		 * @since      1.0.1
		 * @package    Gutentor
		 * @author     Gutentor <info@gutentor.com>
		 */
		public function get_default_values() {
			$blog_attr = [
				'blockID'             => '',
				'gutentorBlockName'             => '',
				'timestamp'           => 0,
				'blockBlogStyle'      => 'blog-grid',
				'blockBlogTemplate'   => 'blog-template1',
				'postsToShow'         => 6,
				'entryMetaFontSize'   => 14,
				'order'               => 'desc',
				'orderBy'             => 'date',
				'categories'          => '',
				'enablePostImage'     => true,
				'enablePostTitle'     => true,
				'enablePostAuthor'    => true,
				'enablePostDate'      => true,
				'enablePostCategory'  => true,
				'enablePostExcerpt'   => true,
				'excerptLength'       => 100,
				'enableButton'        => true,
				'gutentorBlogPostImageLink' => false,
				'gutentorBlogPostImageLinkNewTab' => false,
				'buttonIcon'          => [
					'label' => 'fa-book',
					'value' => 'fas fa-book',
					'code'  => 'f108'
				],
				'buttonText'          => __('Read More'),
				'imageDisplayOptions' => 'normal-image',
				'bgImageOptions'      => [
					'backgroundImage'      => '',
					'height'               => [
						'desktop' => 50,
						'tablet'  => 50,
						'mobile'  => 50
					],
					'backgroundSize'       => '',
					'backgroundPosition'   => '',
					'backgroundRepeat'     => '',
					'backgroundAttachment' => '',
				],
				'imageBorder'         => [
					'borderStyle'        => 'none',
					'borderTop'          => '',
					'borderRight'        => '',
					'borderBottom'       => '',
					'borderLeft'         => '',
					'borderColor'        => '',
					'borderRadiusType'   => 'px',
					'borderRadiusTop'    => '',
					'borderRadiusRight'  => '',
					'borderRadiusBottom' => '',
					'borderRadiusLeft'   => ''
				],
				'imageOverlayColor'   => [

					'enable' => false,
					'normal' => '',
					'hover'  => '',

				],
				'entryMetaColor' => [
					'enable' => false,
					'normal' => '',
					'hover'  => '',
				],
				'blockEntryMetaTypography'   => [

					'fontType'       => '',
					'systemFont'     => '',
					'googleFont'     => '',
					'customFont'     => '',
					'fontSize'       => [
						'desktop' => '',
						'tablet'  => '',
						'mobile'  => '',
					],
					'fontWeight'     => '',
					'textTransform'  => '',
					'fontStyle'      => '',
					'textDecoration' => '',
					'lineHeight'     => [
						'desktop' => '',
						'tablet'  => '',
						'mobile'  => '',
					],
					'letterSpacing'  => [
						'desktop' => '',
						'tablet'  => '',
						'mobile'  => '',
					],
				],
				'blockEntryMetaMargin' => [
					'type'          => 'px',
					'desktopTop'    => '',
					'desktopRight'  => '',
					'desktopBottom' => '',
					'desktopLeft'   => '',
					'tabletTop'     => '',
					'tabletRight'   => '',
					'tabletBottom'  => '',
					'tabletLeft'    => '',
					'mobileTop'     => '',
					'mobileRight'   => '',
					'mobileBottom'  => '',
					'mobileLeft'    => '',
				],
				'blockEntryMetaPadding' => [
					'type'          => 'px',
					'desktopTop'    => '',
					'desktopRight'  => '',
					'desktopBottom' => '',
					'desktopLeft'   => '',
					'tabletTop'     => '',
					'tabletRight'   => '',
					'tabletBottom'  => '',
					'tabletLeft'    => '',
					'mobileTop'     => '',
					'mobileRight'   => '',
					'mobileBottom'  => '',
					'mobileLeft'    => '',
				],
			];
			$blog_attr = apply_filters('gutentor_blog_post_get_default_values', $blog_attr );
			return $blog_attr;
		}

		/**
		 * Dynamic Css
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @param array $data
		 * @param array $attributes
		 * @return array | boolean
		 */
		public function add_dynamic_css( $data, $attributes ) {

			if( $attributes['gutentorBlockName']  != 'gutentor/blog-post'){
				return $data;
			}

			$blog_default_val = $this->get_default_values();
			$attributes       = wp_parse_args($attributes, $blog_default_val);
			$local_dynamic_css            = array();
			$local_dynamic_css['all']     = '';
			$local_dynamic_css['tablet']  = '';
			$local_dynamic_css['desktop'] = '';

			/*Entry Meta Css*/
			$meta_color_enable     = isset($attributes['entryMetaColor']) && $attributes['entryMetaColor']['enable'] ? $attributes['entryMetaColor']['enable'] : '';
			$entry_meta_typography     = (isset($attributes['blockEntryMetaTypography']) && $attributes['blockEntryMetaTypography']) ? $attributes['blockEntryMetaTypography']  : false;
			$entry_meta_margin     = (isset($attributes['blockEntryMetaMargin']) && $attributes['blockEntryMetaMargin']) ? $attributes['blockEntryMetaMargin']  : false;
			$entry_meta_padding    = (isset($attributes['blockEntryMetaPadding']) && $attributes['blockEntryMetaPadding']) ? $attributes['blockEntryMetaPadding']  : false;
			$local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] . ' .entry-meta div {
             '. gutentor_generate_css('color', ($meta_color_enable && $attributes['entryMetaColor']['normal']) ? $attributes['entryMetaColor']['normal']['hex'] : null) . '
             '.gutentor_typography_options_css($entry_meta_typography).'
             '.gutentor_box_four_device_options_css('margin',$entry_meta_margin).'
             '.gutentor_box_four_device_options_css('padding',$entry_meta_padding).'
        }';
			$local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] . ' .entry-meta div:hover,
	        #section-' . $attributes['blockID'] . ' .entry-meta div a:hover{
	           ' . gutentor_generate_css('color', ($meta_color_enable && $attributes['entryMetaColor']['hover']) ? $attributes['entryMetaColor']['hover']['hex'] : null) . '
	        }';

			$local_dynamic_css['tablet']  .= '#section-' . $attributes['blockID'] . ' .entry-meta div{
            '. gutentor_typography_options_responsive_css($entry_meta_typography,'tablet') . '
             '.gutentor_box_four_device_options_css('margin',$entry_meta_margin,'tablet').'
             '.gutentor_box_four_device_options_css('padding',$entry_meta_padding,'tablet').'
            }';
			$local_dynamic_css['desktop'] .= '#section-' . $attributes['blockID'] . ' .entry-meta div{
            '. gutentor_typography_options_responsive_css($entry_meta_typography,'desktop') . '
            '.gutentor_box_four_device_options_css('margin',$entry_meta_margin,'desktop').'
            '.gutentor_box_four_device_options_css('padding',$entry_meta_padding,'desktop').'
        }';

			/*Image overlay css*/
			$local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-single-item-image-box .overlay{
           ' . gutentor_generate_css('color', ($meta_color_enable && $attributes['entryMetaColor']['hover']) ? $attributes['entryMetaColor']['hover']['hex'] : null) . '
        }';
			if ($attributes['enablePostImage']) {

				if ('bg-image' === $attributes['imageDisplayOptions']) {
					$local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-bg-image{
                    '.gutentor_border_css($attributes['imageBorder']) . '
                    '.gutentor_background_image_options($attributes['bgImageOptions']).'
                }';
				}
				else {
					$local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] . ' .gutentor-single-item .gutentor-thumb-image{
                   '.gutentor_border_css($attributes['imageBorder']) . '
                }';
				}
				$local_dynamic_css['tablet'] .= '#section-' . $attributes['blockID'] . '.gutentor-single-item .gutentor-bg-image{
              ' . gutentor_background_responsive_height($attributes['bgImageOptions'],'tablet') . '
            }';
				$local_dynamic_css['desktop'] .= '#section-' . $attributes['blockID'] . '.gutentor-single-item .gutentor-bg-image{
              ' . gutentor_background_responsive_height($attributes['bgImageOptions'],'desktop') . '
            }';
			}

			$output = array_merge_recursive($data, $local_dynamic_css);
			return $output;
		}

		/**
		 * Render Blog Post Data
		 *
		 * @since    1.0.1
		 * @access   public
		 *
		 * @param array $attributes
		 * @param string $content
		 * @return string
		 */
		public function render_callback( $attributes, $content ) {
			$blog_style = '';
			if(gutentor_get_options('gutentor_dynamic_style_location')){
				$gutentor_dynamic_style_location =  gutentor_get_options('gutentor_dynamic_style_location');
				if('default' == $gutentor_dynamic_style_location){
					$blog_style .= $this->get_common_css($attributes);
					$blog_style .= '<style>'.$blog_style.'</style>';
				}

			}

			$blockID = isset($attributes['blockID']) ? $attributes['blockID'] : '';
			$output = '';
			// the query
			$args      = array(
				'posts_per_page'      => $attributes['postsToShow'],
				'orderby'             => $attributes['orderBy'],
				'order'               => $attributes['order'],
				'cat'                 => $attributes['categories'],
				'ignore_sticky_posts' => 1
			);

			$tag = $attributes['blockSectionHtmlTag'] ? $attributes['blockSectionHtmlTag'] : 'section';
			$template = $attributes['blockBlogTemplate'] ? $attributes['blockBlogTemplate'] : '';
			$align = isset($attributes['align']) ? 'align'.$attributes['align'] : '';
			$blockComponentAnimation = isset($attributes['blockComponentAnimation']) ? $attributes['blockComponentAnimation'] : '';
			$blockItemsWrapAnimation = isset($attributes['blockItemsWrapAnimation']) ? $attributes['blockItemsWrapAnimation'] : '';

			$the_query = new WP_Query( $args );

			if ($the_query->have_posts()) :
				$output  .= '<'.$tag.' class="'.apply_filters('gutentor_save_section_class', 'gutentor-section gutentor-blog-post-wrapper '.gutentor_concat_space($template,$align).'', $attributes).'" id="section-' . esc_attr($blockID) . '" '.GutentorAnimationOptionsDataAttr($blockComponentAnimation).'>' . "\n";
				$output .= $blog_style;
				$output .= apply_filters( 'gutentor_save_before_container', '', $attributes );
				$output .= '<div class="grid-container">';
				$output .= apply_filters('gutentor_save_before_block_items', '', $attributes);
				$output .= "<div class='". apply_filters('gutentor_save_grid_item_wrap_class', 'gutentor-grid-item-wrap' , $attributes) . " 
                    ' ".apply_filters( 'gutentor_save_grid_item_wrap_attr','', $attributes  )." ".GutentorAnimationOptionsDataAttr($blockItemsWrapAnimation).">";
				$output .= "<div class='"
				           . apply_filters('gutentor_save_grid_row_class', 'grid-row ' , $attributes) . " 
                    ' ".apply_filters( 'gutentor_save_grid_row_attr','', $attributes  ).">";
				while ($the_query->have_posts()) : $the_query->the_post();
					$thumb_class = has_post_thumbnail() ? 'gutentor-post-has-thumb' : 'gutentor-post-no-thumb';
					$output      .= "<article class='".apply_filters('gutentor_save_grid_column_class', $thumb_class , $attributes) . " 
                    '>";
					$output .= '<div class="gutentor-single-item">';
					$output .= apply_filters('gutentor_save_blog_post_block_template_data', '',get_post(), $attributes);
					$output .= "</div>";/*.gutentor-single-item*/
					$output .= "</article>";/*.article*/
				endwhile;
				$output .= "</div>";/*.grid-row*/
				$output .= "</div>";/*.grid-row-item-wrap*/
				$output .= apply_filters('gutentor_save_after_block_items', '', $attributes);
				$output .= "</div>";/*.grid-container*/
				$output .= apply_filters( 'gutentor_save_after_container', '', $attributes );
				$output .= '</'.$tag.'>';/*.gutentor-blog-post-wrapper*/
			endif;

			// Restore original Post Data
			wp_reset_postdata();
			return $output;
		}
	}
}
Gutentor_Blog_Post::get_instance()->run();