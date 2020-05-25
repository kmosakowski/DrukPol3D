<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Gutentor_Dynamic_CSS' )):

	/**
	 * Create Dynamic CSS
	 * @package Gutentor
	 * @since 1.0.0
	 *
	 */
	class Gutentor_Dynamic_CSS {

		/**
		 * $all_google_fonts
		 *
		 * @var array
		 * @access public
		 * @since 1.0.0
		 *
		 */
		public $all_google_fonts = array();

		/**
		 * Main Instance
		 *
		 * Insures that only one instance of Gutentor_Dynamic_CSS exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @return object
		 */
		public static function instance() {

			// Store the instance locally to avoid private static replication
			static $instance = null;

			// Only run these methods if they haven't been ran previously
			if ( null === $instance ) {
				$instance = new Gutentor_Dynamic_CSS;
			}

			// Always return the instance
			return $instance;
		}

		/**
		 * Run functionality with hooks
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @return void
		 */
		public function run() {
			add_action( 'render_block', array( $this, 'remove_block_css' ), 9999,2 );
			add_filter( 'wp_head', 	array( $this, 'dynamic_css' ),99 );
			add_action( 'save_post', array( $this, 'add_edit_dynamic_css_file' ), 9999,3 );
			add_action( 'wp_enqueue_scripts', array( $this, 'dynamic_css_enqueue' ), 9999 );

			add_filter( 'wp_head', 	array( $this, 'enqueue_google_fonts' ),100 );
			add_filter( 'admin_head', 	array( $this, 'admin_enqueue_google_fonts' ) ,100);

		}

		/**
		 * Set all_google_fonts
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @return void
		 */
		public function google_block_typography_prep( $block ){
			/*<<<<<<<<<=Google Typography Preparation*/
			if ( is_array( $block ) && isset( $block['attrs'] ) ){
				$typography_data = array_filter( $block['attrs'], function ($key) {
					return strpos($key, 'Typography');
				}, ARRAY_FILTER_USE_KEY );

				foreach ( $typography_data as $key => $typography ){
					if( is_array( $typography) && isset( $typography['fontType']) && 'google' == $typography['fontType'] ){
						$this->all_google_fonts[] = array(
							'family' => $typography['googleFont'],
							'font-weight' => $typography['fontWeight']
						);;
					}
				}
			}
			/*Google Typography Preparation=>>>>>>>>*/
		}

		/**
		 * Prepare $post object for google font url or typography
		 *
		 * @since    1.1.4
		 * @access   public
		 *
		 * @return void
		 */
		public function post_google_typography_prep( $post ){
			if( isset($post->ID) ) {
				if ( has_blocks( $post->ID ) ) {
					if ( isset( $post->post_content ) ) {
						$blocks = parse_blocks( $post->post_content );
						if ( is_array( $blocks ) && !empty( $blocks ) ) {
							foreach ( $blocks as $i => $block ) {
								/*google typography*/
								gutentor_dynamic_css()->google_block_typography_prep($block);
							}
						}
					}
				}
			}
		}

		/**
		 * add google font on admin
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @return void|boolean
		 */
		public function admin_enqueue_google_fonts(){
			global $pagenow;
			if (!is_admin()){
				return false;
			}

			if(  in_array( $pagenow, array( 'post.php', 'post-new.php' ) )) {
				global $post;
				$blocks = parse_blocks( $post->post_content );
				if ( ! is_array( $blocks ) || empty( $blocks ) ) {
					return false;
				}
				foreach ( $blocks as $i => $block ) {
					$this->google_block_typography_prep( $block );
				}
				$this->enqueue_google_fonts();
			}
		}

		/**
		 * Remove style from Gutentor Blocks
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @param string $block_content
		 * @param array $block
		 * @return mixed
		 */
		public function remove_block_css( $block_content, $block ){

			if ( 'default' == apply_filters( 'gutentor_dynamic_style_location', 'head' ) ) {
				return $block_content;
			}

			if( !is_admin() && is_array($block) && isset( $block['blockName']) && strpos($block['blockName'], 'gutentor') !== false ){
				$block_content = preg_replace('~<style(.*?)</style>~Usi', "", $block_content);
			}
			return $block_content;
		}

		/**
		 * Add Googe Fonts
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @param string $block_content
		 * @param array $block
		 * @return Mixed
		 */
		public function enqueue_google_fonts() {

			/*font family wp_enqueue_style*/
			$all_google_fonts = apply_filters('gutentor_enqueue_google_fonts', $this->all_google_fonts );

			if ( empty( $all_google_fonts ) ) {
				return false;
			}

			$unique_google_fonts = array();
			if( !empty( $all_google_fonts )){
				foreach( $all_google_fonts as $single_google_font ){
					$font_family = str_replace( ' ', '+', $single_google_font['family'] );
					if( isset( $single_google_font['font-weight']) ){
						$unique_google_fonts[$font_family]['font-weight'][] = $single_google_font['font-weight'];
					}
				}
			}
			$google_font_family = '';
			if( !empty( $unique_google_fonts )){
				foreach( $unique_google_fonts as $font_family => $unique_google_font ){
					if( !empty( $font_family )){
						if ( $google_font_family ) {
							$google_font_family .= '|';
						}
						$google_font_family .= $font_family;
						if( isset( $unique_google_font['font-weight']) ){
							$unique_font_weights = array_unique( $unique_google_font['font-weight'] );
							if( !empty( $unique_font_weights )){
								$google_font_family .= ':' . join( ',', $unique_font_weights );
							}
							else{
								$google_font_family .= ':' . 'regular';
							}

						}
					}
				}
			}

			if ($google_font_family) {
				$google_font_family = str_replace( 'italic', 'i', $google_font_family );
				$fonts_url = add_query_arg(array(
					'family' => $google_font_family
				), '//fonts.googleapis.com/css');
				echo '<link id="gutentor-google-fonts" href="'.esc_url( $fonts_url ).'" rel="stylesheet" data-current-fonts="'.esc_attr(json_encode( $unique_google_fonts )).'" >';
			}
		}

		/**
		 * Minify CSS
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @param string $css
		 * @return mixed
		 */
		public function minify_css( $css = '' ) {

			// Return if no CSS
			if ( ! $css ) {
				return '';
			}

			// remove comments
			$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);

			// Normalize whitespace
			$css = preg_replace( '/\s+/', ' ', $css );

			// Remove ; before }
			$css = preg_replace( '/;(?=\s*})/', '', $css );

			// Remove space after , : ; { } */ >
			$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

			// Remove space before , ; { }
			$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

			// Strips leading 0 on decimal values (converts 0.5px into .5px)
			$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

			// Strips units if value is 0 (converts 0px to 0)
			$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

			/*Removing empty CSS Selector with PHP preg_replace*/
//			$css = preg_replace('/(?:[^\r\n,{}]+)(?:,(?=[^}]*{)|\s*{[\s]*})/', '', $css);

			// Trim
			$css = trim( $css );

			// Return minified CSS
			return $css;

		}

		/**
		 * Inner_blocks
		 *
		 * @since      1.0.0
		 * @package    Gutentor
		 * @author     Gutentor <info@gutentor.com>
		 *
		 * @param array $blocks
		 * @return mixed
		 */
		public function inner_blocks( $blocks ){
			$get_style = '';

			foreach ( $blocks as $i => $block ) {

				/*google typography*/
				$this->google_block_typography_prep($block);

				if ( isset( $block['innerBlocks'] ) && ! empty( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
					$get_style .= $this->inner_blocks( $block['innerBlocks'] );
				}
				if ( $block['blockName'] === 'core/block' && ! empty( $block['attrs']['ref'] ) ) {
					$reusable_block = get_post( $block['attrs']['ref'] );

					if ( ! $reusable_block || 'wp_block' !== $reusable_block->post_type ) {
						return '';
					}

					if ( 'publish' !== $reusable_block->post_status || ! empty( $reusable_block->post_password ) ) {
						return '';
					}

					$blocks = parse_blocks( $reusable_block->post_content );
					$get_style .= $this->inner_blocks( $blocks );
				}

				if ( is_array( $block ) && isset( $block['innerHTML'] ) ){
					if( 'gutentor/blog-post' == $block['blockName']){
						$get_style .= gutentor_block_base()->get_common_css($block['attrs']);
					}
					elseif('gutentor/google-map' == $block['blockName']){
						$get_style .= gutentor_block_base()->get_common_css($block['attrs']);
					}
					else{
						preg_match("'<style>(.*?)</style>'si", $block['innerHTML'], $match );
						if( isset( $match[1])){
							$get_style .= $match[1];
						}
					}
				}
			}
			return $get_style;
		}

		/**
		 * Single Stylesheet
		 *
		 * @since      1.0.0
		 * @package    Gutentor
		 * @author     Gutentor <info@gutentor.com>
		 *
		 * @param object $this_post
		 * @return mixed
		 */
		public function single_stylesheet( $this_post ) {

			$get_style = '';
			if( isset($this_post->ID) ) {
				if ( has_blocks( $this_post->ID ) ) {
					if ( isset( $this_post->post_content ) ) {

						$blocks = parse_blocks( $this_post->post_content );
						if ( ! is_array( $blocks ) || empty( $blocks ) ) {
							return false;
						}
						$get_style = $this->inner_blocks( $blocks );
					}
				}
			}
			return $get_style;
		}

		/**
		 * css prefix
		 *
		 * @since      1.0.0
		 * @package    Gutentor
		 * @author     Gutentor <info@gutentor.com>
		 *
		 * @return mixed
		 */
		public function css_prefix( $post = false ) {
		    if( !$post ){
                global  $post;
            }
            if( isset($post) && isset($post->ID) && has_blocks( $post->ID ) ){
                return $post->ID;
            }
			return false;
		}

		/**
		 * get_global_dynamic_css
		 *
		 * @since      1.0.0
		 * @package    Gutentor
		 * @author     Gutentor <info@gutentor.com>
		 *
		 * @return mixed
		 */
		public function get_global_dynamic_css() {
			$getCSS = '';
			if( gutentor_get_theme_support()){
				$include = array();
				if ( gutentor_get_options( 'gutentor_header_template' ) ) {
					$header_template = gutentor_get_options( 'gutentor_header_template' );
					$include[] = $header_template;

				}
				if ( gutentor_get_options( 'gutentor_footer_template' ) ) {
					$footer_template = gutentor_get_options( 'gutentor_footer_template' );
					$include[] = $footer_template;
				}
				if( !empty( $include ) ){
					$lastposts = get_posts( array(
						'include'   => $include,
						'post_type' => 'wp_block',
					) );

					if ( $lastposts ) {
						foreach ( $lastposts as $post ) :
							setup_postdata( $post );
							$getCSS .= $this->single_stylesheet( $post );
						endforeach;
						wp_reset_postdata();
					}
				}
			}
			$output = gutentor_dynamic_css()->minify_css( $getCSS );
			return $output;
		}

		/**
		 * Get dynamic CSS
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @param array $dynamic_css
		 * 	$dynamic_css = array(
			'all'=>'css',
			'768'=>'css',
			);
		 * @return mixed
		 */
		public function get_singular_dynamic_css( $post = false ){

			$getCSS = '';
            if( $post ){
                $getCSS = $this->single_stylesheet( $post );
            }
			elseif ( is_singular() ) {
				global $post;
				$getCSS = $this->single_stylesheet( $post );
			}
			elseif ( is_archive() || is_home() || is_search() ) {
				global $wp_query;
				if( isset( $wp_query->posts)){
                    foreach ( $wp_query->posts as $post ) {
                        $getCSS .= $this->single_stylesheet( $post );
                    }
                }

			}

			$output = gutentor_dynamic_css()->minify_css( $getCSS );
			return $output;
		}

		/**
		 * Callback function for wp_head
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @return void
		 */
		public static function dynamic_css( ) {

			if ( 'default' == apply_filters( 'gutentor_dynamic_style_location', 'head' ) ) {
				/*Default typography set for font url*/
				if ( is_singular() ) {
					global  $post;
					gutentor_dynamic_css()->post_google_typography_prep($post);
				}
				elseif ( is_archive() || is_home() || is_search() ) {
					global $wp_query;
					if( isset( $wp_query->posts)){
						foreach ( $wp_query->posts as $post ) {
							gutentor_dynamic_css()->post_google_typography_prep($post);
						}
					}
				}
				/*always return*/
				/*since we will not call anything from below codes*/
				return;
			}

            $globalCSS = gutentor_dynamic_css()->get_global_dynamic_css();
            $singularCSS = $combineCSS = '';

			if ( 'file' == apply_filters( 'gutentor_dynamic_style_location', 'head' ) ) {

                global $wp_customize;
                $upload_dir = wp_upload_dir();
				if ( isset( $wp_customize ) || ! file_exists( $upload_dir['basedir'] .'/gutentor/global.css' ) ) {
					$combineCSS .= $globalCSS;
				}
                if ( is_singular() ) {
                    global  $post;
                    $cssPrefix = gutentor_dynamic_css()->css_prefix( $post );
                    if ( isset( $wp_customize ) || ! file_exists( $upload_dir['basedir'] .'/gutentor/p-'.$cssPrefix.'.css'  ) ) {
                        $singularCSS = gutentor_dynamic_css()->get_singular_dynamic_css( $post );
                        $combineCSS .= $singularCSS;
                    }
                }
                elseif ( is_archive() || is_home() || is_search() ) {
                    global $wp_query;
                    if( isset( $wp_query->posts)){
                        foreach ( $wp_query->posts as $post ) {
                            $cssPrefix = gutentor_dynamic_css()->css_prefix( $post );
                            if ( isset( $wp_customize ) || ! file_exists( $upload_dir['basedir'] .'/gutentor/p-'.$cssPrefix.'.css'  ) ) {
                                $singularCSS = gutentor_dynamic_css()->get_singular_dynamic_css( $post );
                                $combineCSS .= $singularCSS;
                            }
                        }
                    }
                }

				// Render CSS in the head
				if ( ! empty( $combineCSS ) ) {
					echo "<!-- Gutentor Dynamic CSS -->\n<style type=\"text/css\" id='gutentor-dynamic-css'>\n" . wp_strip_all_tags( wp_kses_post( $combineCSS ) ) . "\n</style>";
				}

			}
			else {
                if ( is_singular() ) {
                    global  $post;
                    $singularCSS .= gutentor_dynamic_css()->get_singular_dynamic_css( $post );
                }
                elseif ( is_archive() || is_home() || is_search() ) {
                    global $wp_query;
                    if( isset( $wp_query->posts)){
                        foreach ( $wp_query->posts as $post ) {
                            $singularCSS .= gutentor_dynamic_css()->get_singular_dynamic_css( $post );
                        }
                    }
                }
				$combineCSS = $globalCSS.$singularCSS;
				// Render CSS in the head
				if ( ! empty( $combineCSS ) ) {
					echo "<!-- Gutentor Dynamic CSS -->\n<style type=\"text/css\" id='gutentor-dynamic-css'>\n" . wp_strip_all_tags( wp_kses_post( $combineCSS ) ) . "\n</style>";
				}
			}
		}

		/**
		 * Callback function for admin_bar_init
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @return void
		 */
		public static function add_edit_dynamic_css_file( $post_id, $post, $update ) {
            if (
                ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || /*Dealing with autosaves*/
                ! current_user_can( 'edit_post', $post_id )/*Verifying access rights*/
            ){
                return;
            }

			$globalCSS = gutentor_dynamic_css()->get_global_dynamic_css();
			$singularCSS = gutentor_dynamic_css()->get_singular_dynamic_css( $post );

			$cssPrefix = gutentor_dynamic_css()->css_prefix( $post );

			// We will probably need to load this file
			require_once( ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php' );

			global $wp_filesystem;
			$upload_dir = wp_upload_dir();
			$dir = trailingslashit( $upload_dir['basedir'] ) . 'gutentor'. DIRECTORY_SEPARATOR;

			WP_Filesystem();
			$wp_filesystem->mkdir( $dir );
			$wp_filesystem->put_contents( $dir . 'global.css', $globalCSS, 0644 );
			if($cssPrefix ){
				$wp_filesystem->put_contents( $dir . 'p-'.$cssPrefix.'.css', $singularCSS, 0644 );
			}

		}

		/**
		 * Callback function for wp_enqueue_scripts
		 *
		 * @since    1.0.0
		 * @access   public
		 *
		 * @return void
		 */
		public static function dynamic_css_enqueue() {

			// If File is not selected
			if ( 'file' != apply_filters( 'gutentor_dynamic_style_location', 'head' ) ){
				return false;
			}

			global $wp_customize;
			$upload_dir = wp_upload_dir();

			$globalCSS = gutentor_dynamic_css()->get_global_dynamic_css();

			// Render CSS from the custom file
			if ( ! isset( $wp_customize ) ) {

				if ( !empty( $globalCSS ) && file_exists( $upload_dir['basedir'] .'/gutentor/global.css' ) ) {
					wp_enqueue_style( 'gutentor-dynamic-common', trailingslashit( $upload_dir['baseurl'] ) . 'gutentor/global.css', false, null );
				}
				if( is_singular()){
                    global  $post;
                    $cssPrefix = gutentor_dynamic_css()->css_prefix( $post );
                    $singularCSS = gutentor_dynamic_css()->get_singular_dynamic_css( $post );
                    if ( !empty( $singularCSS ) && file_exists( $upload_dir['basedir'] .'/gutentor/p-'.$cssPrefix.'.css'  ) ) {
                        wp_enqueue_style( 'gutentor-dynamic', trailingslashit( $upload_dir['baseurl'] ) . 'gutentor/p-'.$cssPrefix.'.css', false, null );
                    }
                }

                elseif ( is_archive() || is_home() || is_search() ) {
                    global $wp_query;
                    if( isset( $wp_query->posts)){
                        foreach ( $wp_query->posts as $post ) {
                            $cssPrefix = gutentor_dynamic_css()->css_prefix( $post );
                            $singularCSS = gutentor_dynamic_css()->get_singular_dynamic_css( $post );
                            if ( !empty( $singularCSS ) && file_exists( $upload_dir['basedir'] .'/gutentor/p-'.$cssPrefix.'.css'  ) ) {
                                wp_enqueue_style( 'gutentor-dynamic', trailingslashit( $upload_dir['baseurl'] ) . 'gutentor/p-'.$cssPrefix.'.css', false, null );
                            }
                        }
                    }
                }
			}
		}

	}
endif;

/**
 * Call Gutentor_Dynamic_CSS
 *
 * @since    1.0.0
 * @access   public
 *
 */
if( !function_exists( 'gutentor_dynamic_css')){

	function gutentor_dynamic_css() {

		return Gutentor_Dynamic_CSS::instance();
	}
	gutentor_dynamic_css()->run();
}