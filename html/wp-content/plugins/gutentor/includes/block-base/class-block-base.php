<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Gutentor_Block_Base' ) ) {

	/**
	 * Base Class For Gutentor for common functions
	 * @package Gutentor
	 * @since 1.0.1
	 *
	 */
	class Gutentor_Block_Base{

		/**
		 * Prevent some functions to called many times
		 * @access private
		 * @since 1.0.1
		 * @var integer
		 */
		private static $counter = 0;

		/**
		 * Gets an instance of this object.
		 * Prevents duplicate instances which avoid artefacts and improves performance.
		 *
		 * @static
		 * @access public
		 * @since 1.0.1
		 * @return object
		 */
		public static function get_base_instance() {

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
		 * Run Block
		 *
		 * @access public
		 * @since 1.0.1
		 * @return void
		 */
		public function run(){

			if( method_exists( $this, 'load_dependencies' ) ){
				$this->load_dependencies();
			}
			add_action( 'init', array( $this, 'register_and_render' ) );

			if( method_exists( $this, 'add_dynamic_css' ) ){
				add_filter( 'gutentor_dynamic_css', array( $this, 'add_dynamic_css' ), 10, 2 );
			}

			if( self::$counter === 0 ){

				add_filter( 'gutentor_common_attr_default_value', array( $this, 'add_single_item_common_attrs_default_values' ));
				self::$counter++;
			}
		}

		/**
		 * Register this Block
		 * Callback will aut called by this function register_block_type
		 *
		 * @access public
		 * @since 1.0.1
		 * @return void
		 */
		public function register_and_render(){

			$args = array();

			if( method_exists( $this, 'render_callback' ) ){
				$args = array(
					'render_callback' => array( $this, 'render_callback' ),
				);
				if( method_exists( $this, 'get_attrs' ) ){
					$attributes = array_merge_recursive( $this->get_attrs(), $this->get_common_attrs() );
				}
				else{
					$attributes = $this->get_common_attrs();
				}
				$args['attributes'] = $attributes;
			}

            register_block_type( 'gutentor/'.$this->block_name, $args );

        }

        /**
         * Define Common Attributes
         * It Basically Includes Advanced Attributes
         *
         * @since      1.0.0
         * @package    Gutentor
         * @author     Gutentor <info@gutentor.com>
         */
        public function get_common_attrs(){
            $common_attrs = array(

                /*column*/
                'blockItemsColumn' => array(
                    'type'    => 'object',
                    'default' => array(
                        'desktop'   => 'grid-md-4',
                        'tablet'    => 'grid-sm-4',
                        'mobile'    => 'grid-xs-12',
                    )
                ),
                'blockSectionHtmlTag' => array(
                    'type'    => 'string',
                    'default' =>'section'
                ),

                /*Advanced Attr*/
                'blockComponentAnimation' => array(
                    'type' => 'object',
                    'default' => array(
                        'Animation' => 'none',
                        'Delay'     => '',
                        'Speed'     => '',
                        'Iteration' => '',
                    )
                ),
                'blockComponentBGType' => array(
                    'type' => 'string',
                ),
                'blockComponentBGImage' => array(
                    'type' => 'string',
                ),
                'blockComponentBGVideo' => array(
                    'type' => 'object',
                ),
                'blockComponentBGColor' => array(
                    'type' => 'object',
                ),
                'blockComponentBGImageSize' => array(
                    'type' => 'string',
                ),
                'blockComponentBGImagePosition' => array(
                    'type' => 'string',
                ),
                'blockComponentBGImageRepeat' => array(
                    'type' => 'string',
                ),
                'blockComponentBGImageAttachment' => array(
                    'type' => 'string',
                ),
                'blockComponentBGVideoLoop' => array(
                    'type' => 'object',
                    'default'=> true
                ),
                'blockComponentBGVideoMuted' => array(
                    'type' => 'boolean',
                    'default'=> true
                ),
                'blockComponentEnableOverlay' => array(
                    'type' => 'boolean',
                    'default'=> true
                ),
                'blockComponentOverlayColor' => array(
                    'type' => 'string',
                    'default'=> ''
                ),
                'blockComponentBoxBorder' => array(
                    'type' => 'object',
                    'default' => array(
                        'borderStyle'        => 'none',
                        'borderTop'          => '',
                        'borderRight'        => '',
                        'borderBottom'       => '',
                        'borderLeft'         => '',
                        'borderColorNormal'  => '',
                        'borderColorHover'   => '',
                        'borderRadiusType'   => 'px',
                        'borderRadiusTop'    => '',
                        'borderRadiusRight'  => '',
                        'borderRadiusBottom' => '',
                        'borderRadiusLeft'   => '',
                    )
                ),
                'blockComponentMargin' => array(
                    'type' => 'object',
                    'default' => array(
                        'type'          => 'px',
                        'desktopTop'    => '',
                        'desktopRight'  => '',
                        'desktopBottom' => '',
                        'desktopLeft'   => '',
                        'tabletTop'     => '',
                        'tabletRight'   => '',
                        'tabletBottom'  => 'px',
                        'tabletLeft'    => '',
                        'mobileTop'     => '',
                        'mobileRight'   => '',
                        'mobileBottom'  => '',
                        'mobileLeft'    => '',
                    )
                ),
                'blockComponentPadding' => array(
                    'type' => 'object',
                    'default' => array(
                        'type'          => 'px',
                        'desktopTop'    => '',
                        'desktopRight'  => '',
                        'desktopBottom' => '',
                        'desktopLeft'   => '',
                        'tabletTop'     => '',
                        'tabletRight'   => '',
                        'tabletBottom'  => 'px',
                        'tabletLeft'    => '',
                        'mobileTop'     => '',
                        'mobileRight'   => '',
                        'mobileBottom'  => '',
                        'mobileLeft'    => '',
                    )
                ),
                'blockComponentBoxShadowOptions' => array(
                    'type' => 'object',
                    'default' => array(
                        'boxShadowColor'    => '',
                        'boxShadowX'        => '',
                        'boxShadowY'        => '',
                        'boxShadowBlur'     => '',
                        'boxShadowSpread'   => '',
                        'boxShadowPosition' => '',
                    )
                ),

                /*adv shape*/
                'blockShapeTopSelect' => array(
                    'type' => 'string',
                    'default' => '',
                ),
                'blockShapeTopSelectEnableColor' => array(
                    'type' => 'boolean',
                    'default' => '',
                ),
                'blockShapeTopSelectColor' => array(
                    'type' => 'object',
                    'default' => '',
                ),
                'blockShapeTopHeight' => array(
                    'type' => 'object',
                    'default' => array(
                        'type'    => 'px',
                        'desktop' => '',
                        'tablet'  => '',
                        'mobile'  => '',
                    )
                ),
                'blockShapeTopWidth' => array(
                    'type' => 'object',
                    'default' => array(
                        'type'    => 'px',
                        'desktop' => '',
                        'tablet'  => '',
                        'mobile'  => '',
                    )
                ),
                'blockShapeTopPosition' => array(
                    'type' => 'boolean',
                    'default' => '',
                ),
                'blockShapeBottomSelect' => array(
                    'type' => 'string',
                    'default' => '',
                ),
                'blockShapeBottomSelectEnableColor' => array(
                    'type' => 'boolean',
                    'default' => '',
                ),
                'blockShapeBottomSelectColor' => array(
                    'type' => 'object',
                    'default' => '',
                ),
                'blockShapeBottomHeight' => array(
                    'type' => 'object',
                    'default' => array(
                        'type'    => 'px',
                        'desktop' => '',
                        'tablet'  => '',
                        'mobile'  => '',
                    )
                ),
                'blockShapeBottomWidth' => array(
                    'type' => 'object',
                    'default' => array(
                        'type'    => 'px',
                        'desktop' => '',
                        'tablet'  => '',
                        'mobile'  => '',
                    )
                ),
                'blockShapeBottomPosition' => array(
                    'type' => 'boolean',
                    'default' => '',
                ),

                /* block component title*/
                'blockComponentTitleEnable'			=> array(
                    'type'    => 'boolean',
                    'default' => true,
                ),
                'blockComponentTitle'           => array(
                    'type' => 'string',
                    'default' => __('Block Title','gutentor'),
                ),
                'blockComponentTitleTag'           => array(
                    'type' => 'string',
                    'default' => 'h2'
                ),
                'blockComponentTitleAlign'           => array(
                    'type' => 'string',
                    'default' => 'text-center'
                ),
                'blockComponentTitleColorEnable'           => array(
                    'type' => 'boolean',
                    'default' => true
                ),
                'blockComponentTitleColor'           => array(
                    'type' => 'object',
                    'default'=> array(
                        'hex' => '#111111',
                    )
                ),
                'blockComponentTitleTypography'           => array(
                    'type' => 'object',
                    'default' => array(
                        'fontType'       => 'default',
                        'systemFont'     => '',
                        'googleFont'     => '',
                        'customFont'     => '',

                        'desktopFontSize'     => '',
                        'tabletFontSize'     => '',
                        'mobileFontSize'     => '',

                        'fontWeight'     => '',
                        'textTransform'  => '',
                        'fontStyle'      => '',
                        'textDecoration' => '',

                        'desktopLineHeight'     => '',
                        'tabletLineHeight'     => '',
                        'mobileLineHeight'     => '',

                        'desktopLetterSpacing'     => '',
                        'tabletLetterSpacing'     => '',
                        'mobileLetterSpacing'     => '',
                    )
                ),
                'blockComponentTitleMargin' => array(
                    'type' => 'object',
                    'default' => array(
                        'type'       => 'px',
                        'desktopTop'     => '',
                        'desktopRight'     => '',
                        'desktopBottom'     => '',
                        'desktopLeft'     => '',

                        'tabletTop'     => '',
                        'tabletRight'     => '',
                        'tabletBottom'     => '',
                        'tabletLeft'     => '',

                        'mobileTop'     => '',
                        'mobileRight'  => '',
                        'mobileBottom'      => '',
                        'mobileLeft' => '',

                    )
                ),
                'blockComponentTitlePadding' => array(
                    'type' => 'object',
                    'default' => array(
                        'type'       => 'px',
                        'desktopTop'     => '',
                        'desktopRight'     => '',
                        'desktopBottom'     => '',
                        'desktopLeft'     => '',

                        'tabletTop'     => '',
                        'tabletRight'     => '',
                        'tabletBottom'     => '',
                        'tabletLeft'     => '',

                        'mobileTop'     => '',
                        'mobileRight'  => '',
                        'mobileBottom'      => '',
                        'mobileLeft' => '',

                    )
                ),
                'blockComponentTitleAnimation' => array(
                    'type' => 'object',
                    'default' => array(
                        'Animation' => 'none',
                        'Delay'     => '',
                        'Speed'     => '',
                        'Iteration' => '',
                    )
                ),
                'blockComponentTitleDesignEnable' => array(
                    'type'    => 'boolean',
                    'default' => true,
                ),
                'blockComponentTitleSeperatorPosition'  => array(
                    'type' => 'string',
                    'default' => 'seperator-bottom',
                ),

                /* block component sub title*/
                'blockComponentSubTitleEnable' => array(
                    'type'    => 'boolean',
                    'default' => false,
                ),
                'blockComponentSubTitle'  => array(
                    'type' => 'string',
                    'default' => __('Block Title','gutentor'),
                ),
                'blockComponentSubTitleTag'           => array(
                    'type' => 'string',
                    'default' => 'p'
                ),
                'blockComponentSubTitleAlign'           => array(
                    'type' => 'string',
                    'default' => 'text-center'
                ),
                'blockComponentSubTitleColorEnable'           => array(
                    'type' => 'boolean',
                    'default' => true
                ),
                'blockComponentSubTitleColor'           => array(
                    'type' => 'object',
                    'default'=> array(
                        'hex' => '#111111',
                    )
                ),
                'blockComponentSubTitleTypography' => array(
                    'type' => 'object',
                    'default' => array(
                        'fontType'       => 'default',
                        'systemFont'     => '',
                        'googleFont'     => '',
                        'customFont'     => '',

                        'desktopFontSize'     => '',
                        'tabletFontSize'     => '',
                        'mobileFontSize'     => '',

                        'fontWeight'     => '',
                        'textTransform'  => '',
                        'fontStyle'      => '',
                        'textDecoration' => '',

                        'desktopLineHeight'     => '',
                        'tabletLineHeight'     => '',
                        'mobileLineHeight'     => '',

                        'desktopLetterSpacing'     => '',
                        'tabletLetterSpacing'     => '',
                        'mobileLetterSpacing'     => '',

                    )
                ),
                'blockComponentSubTitleMargin' => array(
                    'type' => 'object',
                    'default' => array(
                        'type'       => 'px',
                        'desktopTop'     => '',
                        'desktopRight'     => '',
                        'desktopBottom'     => '',
                        'desktopLeft'     => '',

                        'tabletTop'     => '',
                        'tabletRight'     => '',
                        'tabletBottom'     => '',
                        'tabletLeft'     => '',

                        'mobileTop'     => '',
                        'mobileRight'  => '',
                        'mobileBottom'      => '',
                        'mobileLeft' => '',

                    )
                ),
                'blockComponentSubTitlePadding' => array(
                    'type' => 'object',
                    'default' => array(
                        'type'       => 'px',
                        'desktopTop'     => '',
                        'desktopRight'     => '',
                        'desktopBottom'     => '',
                        'desktopLeft'     => '',

                        'tabletTop'     => '',
                        'tabletRight'     => '',
                        'tabletBottom'     => '',
                        'tabletLeft'     => '',

                        'mobileTop'     => '',
                        'mobileRight'  => '',
                        'mobileBottom'      => '',
                        'mobileLeft' => '',

                    )
                ),
                'blockComponentSubTitleAnimation' => array(
                    'type' => 'object',
                    'default' => array(
                        'Animation'       => 'px',
                        'Delay'     => '',
                        'Speed'     => '',
                        'Iteration'     => '',
                    )
                ),
                'blockComponentSubTitleDesignEnable' => array(
                    'type'    => 'boolean',
                    'default' => true,
                ),
                'blockComponentSubTitleSeperatorPosition'  => array(
                    'type' => 'string',
                    'default' => 'seperator-bottom',
                ),

                /* primary button */
                'blockComponentPrimaryButtonEnable'    => array(
                    'type' => 'boolean',
                    'default' => false,
                ),
                'blockComponentPrimaryButtonLinkOptions' => array(
                    'type' => 'object',
                    'default' => array(
                        'openInNewTab' => false,
                        'rel' => '',
                    ),
                ),
                'blockComponentPrimaryButtonColor'    => array(
                    'type' => 'object',
                    'default' => array(
                        'enable' => true,
                        'normal' => array(
                            'hex' => '#275cf6',
                            'rgb' => array(
                                'r' => '39',
                                'g' => '92',
                                'b' => '246',
                                'a' => '1',
                            )
                        ),
                        'hover' => array(
                            'hex' => '#1949d4',
                            'rgb' => array(
                                'r' => '25',
                                'g' => '73',
                                'b' => '212',
                                'a' => '1',
                            )
                        ),
                    )
                ),
                'blockComponentPrimaryButtonTextColor'    => array(
                    'type' => 'object',
                    'default' => array(
                        'enable' => true,
                        'normal' => array(
                            'hex' => '#fff',
                        ),
                        'hover'=>'',
                    )
                ),
                'blockComponentPrimaryButtonMargin'    => array(
                    'type' => 'object',
                    'default' => array(
                        'type' => 'px',
                        'desktopTop' => '',
                        'desktopRight' => '',
                        'desktopBottom' => '',
                        'desktopLeft' => '',
                        'tabletTop' => '',
                        'tabletRight' => '',
                        'tabletBottom' => '',
                        'tabletLeft' => '',
                        'mobileTop' => '',
                        'mobileRight' => '',
                        'mobileBottom' => '',
                        'mobileLeft' => '',
                    )
                ),
                'blockComponentPrimaryButtonPadding'    => array(
                    'type' => 'object',
                    'default' => array(
                        'type' => 'px',
                        'desktopTop' => '12',
                        'desktopRight' => '25',
                        'desktopBottom' => '12',
                        'desktopLeft' => '25',
                        'tabletTop' => '12',
                        'tabletRight' => '25',
                        'tabletBottom' => '12',
                        'tabletLeft' => '25',
                        'mobileTop' => '12',
                        'mobileRight' => '25',
                        'mobileBottom' => '12',
                        'mobileLeft' => '25',
                    ),
                ),
                'blockComponentPrimaryButtonIconOptions' => array(
                    'type' => 'object',
                    'default' => array(
                        'position' => 'hide',
                        'size' => '',
                    )
                ),
                'blockComponentPrimaryButtonIconMargin' => array(
                    'type' => 'object',
                    'default' => array(
                        'type' => 'px',
                        'desktopTop' => '',
                        'desktopRight' => '',
                        'desktopBottom' => '',
                        'desktopLeft' => '',
                        'tabletTop' => '',
                        'tabletRight' => '',
                        'tabletBottom' => '',
                        'tabletLeft' => '',
                        'mobileTop' => '',
                        'mobileRight' => '',
                        'mobileBottom' => '',
                        'mobileLeft' => '',
                    )
                ),
                'blockComponentPrimaryButtonIconPadding' => array(
                    'type' => 'object',
                    'default' => array(
                        'type' => 'px',
                        'desktopTop' => '',
                        'desktopRight' => '',
                        'desktopBottom' => '',
                        'desktopLeft' => '',
                        'tabletTop' => '',
                        'tabletRight' => '',
                        'tabletBottom' => '',
                        'tabletLeft' => '',
                        'mobileTop' => '',
                        'mobileRight' => '',
                        'mobileBottom' => '',
                        'mobileLeft' => '',
                    )
                ),
                'blockComponentPrimaryButtonBorder' => array(
                    'type' => 'object',
                    'default' => array(
                        'borderStyle' => '',
                        'borderTop' => '',
                        'borderRight' => '',
                        'borderBottom' => '',
                        'borderLeft' => '',
                        'borderColorNormal' => '',
                        'borderColorHover' => '',
                        'borderRadiusType' => 'px',
                        'borderRadiusTop' => '3',
                        'borderRadiusRight' => '3',
                        'borderRadiusBottom' => '3',
                        'borderRadiusLeft' => '3',
                    )
                ),
                'blockComponentPrimaryButtonBoxShadow'    => array(
                    'type' => 'object',
                    'default' => array(
                        'boxShadowColor' => '',
                        'boxShadowX' => '',
                        'boxShadowY' => '',
                        'boxShadowBlur' => '',
                        'boxShadowSpread' => '',
                        'boxShadowPosition' => '',
                    )
                ),
                'blockComponentPrimaryButtonTypography'    => array(
                    'type' => 'object',
                    'default' => array(
                        'fontType'             => 'system',
                        'systemFont'           => '',
                        'googleFont'           => '',
                        'customFont'           => '',

                        'desktopFontSize'      => '16',
                        'tabletFontSize'       => '16',
                        'mobileFontSize'       => '16',

                        'fontWeight'           => '',
                        'textTransform'        =>'normal',
                        'fontStyle'            => '',
                        'textDecoration'      => '',

                        'desktopLineHeight'    => '',
                        'tabletLineHeight'     => '',
                        'mobileLineHeight'     => '',

                        'desktopLetterSpacing' => '',
                        'tabletLetterSpacing'  => '',
                        'mobileLetterSpacing'  => ''

                    )
                ),
                'blockComponentPrimaryButtonIcon' => array(
                    'type' => 'object',
                    'default' => array(
                        'label'             => 'fa-book',
                        'value'             => 'fas fa-book',
                        'code'             => 'f108',
                    )
                ),
                'blockComponentPrimaryButtonText' => array(
                    'type' => 'string',
                    'default'=>   __('View More')
                ),
                'blockComponentPrimaryButtonLink' => array(
                    'type' => 'string',
                    'default'=>   __('#')
                ),

                /*Secondary Button*/
                'blockComponentSecondaryButtonLinkOptions' => array(
                    'type' => 'object',
                    'default' => array(
                        'openInNewTab' => false,
                        'rel' => '',
                    ),
                ),
                'blockComponentSecondaryButtonColor'    => array(
                    'type' => 'object',
                    'default' => array(
                        'enable' => true,
                        'normal' => array(
                            'hex' => '#275cf6',
                            'rgb' => array(
                                'r' => '39',
                                'g' => '92',
                                'b' => '246',
                                'a' => '1',
                            )
                        ),
                        'hover' => array(
                            'hex' => '#1949d4',
                            'rgb' => array(
                                'r' => '25',
                                'g' => '73',
                                'b' => '212',
                                'a' => '1',
                            )
                        ),
                    )
                ),
                'blockComponentSecondaryButtonTextColor'    => array(
                    'type' => 'object',
                    'default' => array(
                        'enable' => true,
                        'normal' => array(
                            'hex' => '#fff',
                        ),
                        'hover'=>'',
                    )
                ),
                'blockComponentSecondaryButtonMargin'    => array(
                    'type' => 'object',
                    'default' => array(
                        'type' => 'px',
                        'desktopTop' => '',
                        'desktopRight' => '',
                        'desktopBottom' => '',
                        'desktopLeft' => '',
                        'tabletTop' => '',
                        'tabletRight' => '',
                        'tabletBottom' => '',
                        'tabletLeft' => '',
                        'mobileTop' => '',
                        'mobileRight' => '',
                        'mobileBottom' => '',
                        'mobileLeft' => '',
                    )
                ),
                'blockComponentSecondaryButtonPadding'    => array(
                    'type' => 'object',
                    'default' => array(
                        'type' => 'px',
                        'desktopTop' => '12',
                        'desktopRight' => '25',
                        'desktopBottom' => '12',
                        'desktopLeft' => '25',
                        'tabletTop' => '12',
                        'tabletRight' => '25',
                        'tabletBottom' => '12',
                        'tabletLeft' => '25',
                        'mobileTop' => '12',
                        'mobileRight' => '25',
                        'mobileBottom' => '12',
                        'mobileLeft' => '25',
                    ),
                ),
                'blockComponentSecondaryButtonIconOptions' => array(
                    'type' => 'object',
                    'default' => array(
                        'position' => 'hide',
                        'size' => '',
                    )
                ),
                'blockComponentSecondaryButtonIconMargin' => array(
                    'type' => 'object',
                    'default' => array(
                        'type' => 'px',
                        'desktopTop' => '',
                        'desktopRight' => '',
                        'desktopBottom' => '',
                        'desktopLeft' => '',
                        'tabletTop' => '',
                        'tabletRight' => '',
                        'tabletBottom' => '',
                        'tabletLeft' => '',
                        'mobileTop' => '',
                        'mobileRight' => '',
                        'mobileBottom' => '',
                        'mobileLeft' => '',
                    )
                ),
                'blockComponentSecondaryButtonIconPadding' => array(
                    'type' => 'object',
                    'default' => array(
                        'type' => 'px',
                        'desktopTop' => '',
                        'desktopRight' => '',
                        'desktopBottom' => '',
                        'desktopLeft' => '',
                        'tabletTop' => '',
                        'tabletRight' => '',
                        'tabletBottom' => '',
                        'tabletLeft' => '',
                        'mobileTop' => '',
                        'mobileRight' => '',
                        'mobileBottom' => '',
                        'mobileLeft' => '',
                    )
                ),
                'blockComponentSecondaryButtonBorder' => array(
                    'type' => 'object',
                    'default' => array(
                        'borderStyle' => '',
                        'borderTop' => '',
                        'borderRight' => '',
                        'borderBottom' => '',
                        'borderLeft' => '',
                        'borderColorNormal' => '',
                        'borderColorHover' => '',
                        'borderRadiusType' => 'px',
                        'borderRadiusTop' => '3',
                        'borderRadiusRight' => '3',
                        'borderRadiusBottom' => '3',
                        'borderRadiusLeft' => '3',
                    )
                ),
                'blockComponentSecondaryButtonBoxShadow'    => array(
                    'type' => 'object',
                    'default' => array(
                        'boxShadowColor' => '',
                        'boxShadowX' => '',
                        'boxShadowY' => '',
                        'boxShadowBlur' => '',
                        'boxShadowSpread' => '',
                        'boxShadowPosition' => '',
                    )
                ),
                'blockComponentSecondaryButtonTypography'    => array(
                    'type' => 'object',
                    'default' => array(
                        'fontType'             => 'system',
                        'systemFont'           => '',
                        'googleFont'           => '',
                        'customFont'           => '',

                        'desktopFontSize'      => '16',
                        'tabletFontSize'       => '16',
                        'mobileFontSize'       => '16',

                        'fontWeight'           => '',
                        'textTransform'        =>'normal',
                        'fontStyle'            => '',
                        'textDecoration'      => '',

                        'desktopLineHeight'    => '',
                        'tabletLineHeight'     => '',
                        'mobileLineHeight'     => '',

                        'desktopLetterSpacing' => '',
                        'tabletLetterSpacing'  => '',
                        'mobileLetterSpacing'  => ''

                    )
                ),
                'blockComponentSecondaryButtonIcon' => array(
                    'type' => 'object',
                    'default' => array(
                        'label'             => 'fa-book',
                        'value'             => 'fas fa-book',
                        'code'             => 'f108',
                    )
                ),
                'blockComponentSecondaryButtonText' => array(
                    'type' => 'string',
                    'default'=>   __('View More')
                ),
                'blockComponentSecondaryButtonLink' => array(
                    'type' => 'string',
                    'default'=>   __('#')
                ),

                /*carousel attr*/
                'blockItemsCarouselEnable' => array(
                    'type' => 'boolean',
                    'default'=> false
                ),
                'blockItemsCarouselDots' => array(
                    'type' => 'boolean',
                    'default'=> false
                ),
                'blockItemsCarouselDotsTablet' => array(
                    'type' => 'boolean',
                    'default'=> false
                ),
                'blockItemsCarouselDotsMobile' => array(
                    'type' => 'boolean',
                    'default'=> false
                ),
                'blockItemsCarouselDotsColor' => array(
                    'type'   => 'object',
                    'default'=> array(
                        'enable' => false,
                        'normal' => '',
                        'hover'  => ''
                    ),
                ),
                'blockItemsCarouselDotsButtonBorder' => array(
                    'type'   => 'object',
                    'default'=> array(
                        'borderStyle'        => 'none',
                        'borderTop'          => '',
                        'borderRight'        => '',
                        'borderBottom'       => '',
                        'borderLeft'         => '',
                        'borderColorNormal'  => '',
                        'borderColorHover'   => '',
                        'borderRadiusType'   => 'px',
                        'borderRadiusTop'    => '',
                        'borderRadiusRight'  => '',
                        'borderRadiusBottom' => '',
                        'borderRadiusLeft'   => ''
                    ),
                ),
                'blockItemsCarouselDotsButtonHeight' => array(
                    'type' => 'object',
                ),
                'blockItemsCarouselDotsButtonWidth' => array(
                    'type' => 'object',
                ),
                'blockItemsCarouselArrows' => array(
                    'type' => 'boolean',
                    'default'=> true
                ),
                'blockItemsCarouselArrowsTablet' => array(
                    'type' => 'boolean',
                    'default'=> true
                ),
                'blockItemsCarouselArrowsMobile' => array(
                    'type' => 'boolean',
                    'default'=> true
                ),
                'blockItemsCarouselArrowsBgColor' => array(
                    'type'   => 'object',
                    'default'=> array(
                        'enable' => false,
                        'normal' => '',
                        'hover'  => ''
                    ),
                ),
                'blockItemsCarouselArrowsTextColor' => array(
                    'type'   => 'object',
                    'default'=> array(
                        'enable' => false,
                        'normal' => '',
                        'hover'  => ''
                    ),
                ),
                'blockItemsCarouselInfinite' => array(
                    'type' => 'boolean',
                    'default'=> false
                ),
                'blockItemsCarouselFade' => array(
                    'type' => 'boolean',
                    'default'=> false
                ),
                'blockItemsCarouselAutoPlay' => array(
                    'type' => 'boolean',
                    'default'=> false
                ),
                'blockItemsCarouselSlideSpeed' => array(
                    'type' => 'number',
                    'default'=> 300
                ),
                'blockItemsCarouselCenterMode' => array(
                    'type' => 'boolean',
                    'default'=> false
                ),
                'blockItemsCarouselCenterPadding' => array(
                    'type' => 'number',
                    'default'=> 60
                ),
                'blockItemsCarouselAutoPlaySpeed' => array(
                    'type' => 'number',
                    'default'=> 1200
                ),
                'blockItemsCarouselResponsiveSlideItem' => array(
                    'type'   => 'object',
                    'default'=> array(
                        'desktop' => '4',
                        'tablet'=> '3',
                        'mobile' => '2',
                    ),
                ),
                'blockItemsCarouselResponsiveSlideScroll' => array(
                    'type'   => 'object',
                    'default'=> array(
                        'desktop' => '4',
                        'tablet'  => '3',
                        'mobile'  => '2',
                    ),
                ),

                'blockItemsCarouselNextArrow' => array(
                    'type'   => 'object',
                    'default'=> array(
                        'label' => 'fa-angle-right',
                        'value'=> 'fas fa-angle-right',
                        'code' => 'f105',
                    ),
                ),
                'blockItemsCarouselPrevArrow' => array(
                    'type'   => 'object',
                    'default'=> array(
                        'label' => 'fa-angle-left',
                        'value'=> 'fas fa-angle-left',
                        'code' => 'f104',
                    ),
                ),
                'blockItemsCarouselButtonIconSize' => array(
                    'type' => 'number',
                    'default'=> 16
                ),
                'blockItemsCarouselArrowButtonHeight' => array(
                    'type'   => 'object',
                    'default'=> array(
                        'desktop' => '40',
                        'tablet'  => '30',
                        'mobile'  => '20',
                    ),
                ),
                'blockItemsCarouselArrowButtonWidth' => array(
                    'type'   => 'object',
                    'default'=> array(
                        'desktop' => '40',
                        'tablet'  => '30',
                        'mobile'  => '20',
                    ),
                ),
                'blockItemsCarouselArrowButtonBorder' => array(
                    'type'   => 'object',
                    'default'=> array(
                        'borderStyle'        => 'none',
                        'borderTop'          => '',
                        'borderRight'        => '',
                        'borderBottom'       => '',
                        'borderLeft'         => '',
                        'borderColorNormal'  => '',
                        'borderColorHover'   => '',
                        'borderRadiusType'   => 'px',
                        'borderRadiusTop'    => '',
                        'borderRadiusRight'  => '',
                        'borderRadiusBottom' => '',
                        'borderRadiusLeft'   => ''
                    ),
                ),

                /*Image Options attr*/
                'blockImageBoxImageOverlayColor' => array(
                    'type'    => 'object',
                    'default' => array(
                        'enable' => false,
                        'normal' => '',
                        'hover'  => '',
                    ),
                ),
                'blockFullImageEnable' => array(
                    'type'    => 'boolean',
                    'default'=>false
                ),
                'blockEnableImageBoxWidth' => array(
                    'type'    => 'boolean',
                    'default'=>false
                ),
                'blockImageBoxWidth' => array(
                    'type'    => 'number',
                    'default'=>''
                ),
                'blockEnableImageBoxHeight' => array(
                    'type'    => 'boolean',
                    'default'=>false
                ),
                'blockImageBoxHeight' => array(
                    'type'    => 'number',
                    'default'=>''
                ),
                'blockEnableImageBoxDisplayOptions' => array(
                    'type'    => 'boolean',
                    'default' => false
                ),
                'blockImageBoxDisplayOptions' => array(
                    'type'    => 'string',
                    'default' =>'normal-image'
                ),
                'blockImageBoxBackgroundImageOptions' => array(
                    'type'    => 'object',
                    'default' => array(

                        'backgroundImage' => '',
                        'desktopHeight' => '',
                        'tabletHeight'  => '',
                        'mobileHeight'  => '',

                        'backgroundSize'       => '',
                        'backgroundPosition'   => '',
                        'backgroundRepeat'     => '',
                        'backgroundAttachment' => '',
                    ),
                ),
                'blockEnableImageBoxBorder' => array(
                    'type'    => 'boolean',
                    'default' => false
                ),
                'blockImageBoxBorder' => array(
                    'type'    => 'object',
                    'default' => array(
                        'borderStyle'        => 'none',
                        'borderTop'          => '',
                        'borderRight'        => '',
                        'borderBottom'       => '',
                        'borderLeft'         => '',
                        'borderColorNormal'  => '',
                        'borderColorHover'   => '',
                        'borderRadiusType'   => 'px',
                        'borderRadiusTop'    => '',
                        'borderRadiusRight'  => '',
                        'borderRadiusBottom' => '',
                        'borderRadiusLeft'   => '',
                    ),
                ),

                /*item Wrap*/
                'blockItemsWrapMargin' => array(
                    'type' => 'object',
                    'default' => array(
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
                    )
                ),
                'blockItemsWrapPadding' => array(
                    'type' => 'object',
                    'default' => array(
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
                    )
                ),
                'blockItemsWrapAnimation' => array(
                    'type' => 'object',
                    'default' => array(
                        'Animation' => 'none',
                        'Delay'     => '',
                        'Speed'     => '',
                        'Iteration' => '',
                    )
                ),
            );

            return apply_filters('gutentor_get_common_attrs', $common_attrs );
        }

        /**
         * Block Single Items Common attributes
         * eg Title, Description, Button etc
         *
         * @access public
         * @since 1.0.1
         * @return array
         */
        public function get_single_item_common_attrs(){

            return array(

                /*single item title*/
                'blockSingleItemTitleEnable' => array(
                    'type'    => 'boolean',
                    'default' => true,
                ),
                'blockSingleItemTitleTag'           => array(
                    'type' => 'string',
                    'default' => 'h3'
                ),
                'blockSingleItemTitleColor'           => array(
                    'type' => 'object',
                    'default'=> array(
                        'enable' => 'false',
                        'normal' => array(
                            'hex' => '#111111',
                        ),
                        'hover' => '',
                    )
                ),
                'blockSingleItemTitleTypography'           => array(
                    'type' => 'object',
                    'default' => array(
                        'fontType'   => 'default',
                        'systemFont' => '',
                        'googleFont' => '',
                        'customFont' => '',

                        'desktopFontSize' => '',
                        'tabletFontSize'  => '',
                        'mobileFontSize'  => '',

                        'fontWeight'     => '',
                        'textTransform'  => '',
                        'fontStyle'      => '',
                        'textDecoration' => '',

                        'desktopLineHeight' => '',
                        'tabletLineHeight'  => '',
                        'mobileLineHeight'  => '',

                        'desktopLetterSpacing' => '',
                        'tabletLetterSpacing'  => '',
                        'mobileLetterSpacing'  => '',
                    )
                ),
                'blockSingleItemTitleMargin' => array(
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
                'blockSingleItemTitlePadding' => array(
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

                /* single item description*/
                'blockSingleItemDescriptionEnable' => array(
                    'type'    => 'boolean',
                    'default' => true,
                ),
                'blockSingleItemDescriptionTag'           => array(
                    'type' => 'string',
                    'default' => 'p'
                ),
                'blockSingleItemDescriptionColor'           => array(
                    'type' => 'object',
                    'default'=> array(
                        'enable' => 'false',
                        'normal' => '',
                        'hover' => '',
                    )
                ),
                'blockSingleItemDescriptionTypography'           => array(
                    'type' => 'object',
                    'default' => array(
                        'fontType'   => 'default',
                        'systemFont' => '',
                        'googleFont' => '',
                        'customFont' => '',

                        'desktopFontSize' => '',
                        'tabletFontSize'  => '',
                        'mobileFontSize'  => '',

                        'fontWeight'     => '',
                        'textTransform'  => '',
                        'fontStyle'      => '',
                        'textDecoration' => '',

                        'desktopLineHeight' => '',
                        'tabletLineHeight'  => '',
                        'mobileLineHeight'  => '',

                        'desktopLetterSpacing' => '',
                        'tabletLetterSpacing'  => '',
                        'mobileLetterSpacing'  => '',
                    )
                ),
                'blockSingleItemDescriptionMargin' => array(
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
                'blockSingleItemDescriptionPadding' => array(
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

                /*single item button*/
                'blockSingleItemButtonEnable' => array(
                    'type'    => 'boolean',
                    'default' => false,
                ),
                'blockSingleItemButtonLinkOptions' => array(
                    'type' => 'object',
                    'default' => array(
                        'openInNewTab' => false,
                        'rel'          => '',
                    ),
                ),
                'blockSingleItemButtonColor'    => array(
                    'type' => 'object',
                    'default' => array(
                        'enable' => true,
                        'normal' => array(
                            'hex' => '#275cf6',
                            'rgb' => array(
                                'r' => '39',
                                'g' => '92',
                                'b' => '246',
                                'a' => '1',
                            )
                        ),
                        'hover' => array(
                            'hex' => '#1949d4',
                            'rgb' => array(
                                'r' => '25',
                                'g' => '73',
                                'b' => '212',
                                'a' => '1',
                            )
                        ),
                    )
                ),
                'blockSingleItemButtonTextColor'    => array(
                    'type' => 'object',
                    'default' => array(
                        'enable' => true,
                        'normal' => array(
                            'hex' => '#fff',
                        ),
                        'hover'=>'',
                    )
                ),
                'blockSingleItemButtonMargin'    => array(
                    'type' => 'object',
                    'default' => array(
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
                    )
                ),
                'blockSingleItemButtonPadding'    => array(
                    'type' => 'object',
                    'default' => array(
                        'type'          => 'px',
                        'desktopTop'    => '10',
                        'desktopRight'  => '15',
                        'desktopBottom' => '10',
                        'desktopLeft'   => '15',
                        'tabletTop'     => '10',
                        'tabletRight'   => '15',
                        'tabletBottom'  => '10',
                        'tabletLeft'    => '15',
                        'mobileTop'     => '10',
                        'mobileRight'   => '15',
                        'mobileBottom'  => '10',
                        'mobileLeft'    => '15',
                    ),
                ),
                'blockSingleItemButtonIconOptions' => array(
                    'type' => 'object',
                    'default' => array(
                        'position' => 'hide',
                        'size'     => '',
                    )
                ),
                'blockSingleItemButtonIconMargin' => array(
                    'type' => 'object',
                    'default' => array(
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
                    )
                ),
                'blockSingleItemButtonIconPadding' => array(
                    'type' => 'object',
                    'default' => array(
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
                    )
                ),
                'blockSingleItemButtonBorder' => array(
                    'type' => 'object',
                    'default' => array(
                        'borderStyle'        => '',
                        'borderTop'          => '',
                        'borderRight'        => '',
                        'borderBottom'       => '',
                        'borderLeft'         => '',
                        'borderColorNormal'  => '',
                        'borderColorHover'   => '',
                        'borderRadiusType'   => 'px',
                        'borderRadiusTop'    => '3',
                        'borderRadiusRight'  => '3',
                        'borderRadiusBottom' => '3',
                        'borderRadiusLeft'   => '3',
                    )
                ),
                'blockSingleItemButtonBoxShadow'    => array(
                    'type' => 'object',
                    'default' => array(
                        'boxShadowColor'    => '',
                        'boxShadowX'        => '',
                        'boxShadowY'        => '',
                        'boxShadowBlur'     => '',
                        'boxShadowSpread'   => '',
                        'boxShadowPosition' => '',
                    )
                ),
                'blockSingleItemButtonTypography'    => array(
                    'type' => 'object',
                    'default' => array(
                        'fontType'             => 'system',
                        'systemFont'           => '',
                        'googleFont'           => '',
                        'customFont'           => '',

                        'desktopFontSize'      => '14',
                        'tabletFontSize'       => '14',
                        'mobileFontSize'       => '14',

                        'fontWeight'           => '',
                        'textTransform'        =>'normal',
                        'fontStyle'            => '',
                        'textDecoration'      => '',

                        'desktopLineHeight'    => '',
                        'tabletLineHeight'     => '',
                        'mobileLineHeight'     => '',

                        'desktopLetterSpacing' => '',
                        'tabletLetterSpacing'  => '',
                        'mobileLetterSpacing'  => ''
                    )
                ),

                /* single item box title*/
                'blockSingleItemBoxColor' => array(
                    'type' => 'object',
                    'default' => array(
                        'enable'       => true,
                        'normal'     => '',
                        'hover'     => '',
                    )
                ),
                'blockSingleItemBoxBorder' => array(
                    'type' => 'object',
                    'default' => array(
                        'borderStyle'        => '',
                        'borderTop'          => '',
                        'borderRight'        => '',
                        'borderBottom'       => '',
                        'borderLeft'         => '',
                        'borderColorNormal'  => '',
                        'borderColorHover'   => '',
                        'borderRadiusType'   => 'px',
                        'borderRadiusTop'    => '3',
                        'borderRadiusRight'  => '3',
                        'borderRadiusBottom' => '3',
                        'borderRadiusLeft'   => '3',
                    )
                ),
                'blockSingleItemBoxShadowOptions'    => array(
                    'type' => 'object',
                    'default' => array(
                        'boxShadowColor'    => '',
                        'boxShadowX'        => '',
                        'boxShadowY'        => '',
                        'boxShadowBlur'     => '',
                        'boxShadowSpread'   => '',
                        'boxShadowPosition' => '',
                    )
                ),
                'blockSingleItemBoxMargin' => array(
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
                'blockSingleItemBoxPadding' => array(
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
        }

        /**
         * Gutentor Common Attr Default Value
         * Default Values
         *
         * @since      1.0.0
         * @package    Gutentor
         * @author     Gutentor <info@gutentor.com>
         */
        public function get_common_attrs_default_values() {
            $default_attr = [
                /*column*/
                'blockItemsColumn' => [
                    'desktop'   => 'grid-md-4',
                    'tablet'    => 'grid-sm-4',
                    'mobile'    => 'grid-xs-12',
                ],
                'blockSectionHtmlTag' => 'section',
                'gutentorBlockName' => '',
                'blockID' => '',

                /*Advanced attr*/
                'blockComponentAnimation' => [
                    'Animation' => 'none',
                    'Delay'     => '',
                    'Speed'     => '',
                    'Iteration' => '',
                ],
                'blockComponentBGType'  => '',
                'blockComponentBGImage'  => '',
                'blockComponentBGVideo'  => '',
                'blockComponentBGColor'  => '',
                'blockComponentBGImageSize'  => '',
                'blockComponentBGImagePosition'  => '',
                'blockComponentBGImageRepeat'  => '',
                'blockComponentBGImageAttachment'  => '',
                'blockComponentBGVideoLoop'  => true,
                'blockComponentBGVideoMuted'  => true,
                'blockComponentEnableOverlay'  => true,
                'blockComponentOverlayColor'  => '',
                'blockComponentBoxBorder' => [
                    'borderStyle'        => 'none',
                    'borderTop'          => '',
                    'borderRight'        => '',
                    'borderBottom'       => '',
                    'borderLeft'         => '',
                    'borderColorNormal'  => '',
                    'borderColorHover'   => '',
                    'borderRadiusType'   => 'px',
                    'borderRadiusTop'    => '',
                    'borderRadiusRight'  => '',
                    'borderRadiusBottom' => '',
                    'borderRadiusLeft'   => '',
                ],
                'blockComponentMargin' => [
                    'type'          => 'px',
                    'desktopTop'    => '',
                    'desktopRight'  => '',
                    'desktopBottom' => '',
                    'desktopLeft'   => '',
                    'tabletTop'     => '',
                    'tabletRight'   => '',
                    'tabletBottom'  => 'px',
                    'tabletLeft'    => '',
                    'mobileTop'     => '',
                    'mobileRight'   => '',
                    'mobileBottom'  => '',
                    'mobileLeft'    => '',
                ],
                'blockComponentPadding' => [
                    'type'          => 'px',
                    'desktopTop'    => '',
                    'desktopRight'  => '',
                    'desktopBottom' => '',
                    'desktopLeft'   => '',
                    'tabletTop'     => '',
                    'tabletRight'   => '',
                    'tabletBottom'  => 'px',
                    'tabletLeft'    => '',
                    'mobileTop'     => '',
                    'mobileRight'   => '',
                    'mobileBottom'  => '',
                    'mobileLeft'    => '',
                ],
                'blockComponentBoxShadowOptions' => [
                    'boxShadowColor'    => '',
                    'boxShadowX'        => '',
                    'boxShadowY'        => '',
                    'boxShadowBlur'     => '',
                    'boxShadowSpread'   => '',
                    'boxShadowPosition' => '',
                ],

                /*adv shape*/
                'blockShapeTopSelect' => '',
                'blockShapeTopSelectEnableColor' => '',
                'blockShapeTopSelectColor' => '',
                'blockShapeTopHeight' => [

                    'type'    => 'px',
                    'desktop' => '',
                    'tablet'  => '',
                    'mobile'  => '',
                ],
                'blockShapeTopWidth' => [

                    'type'    => 'px',
                    'desktop' => '',
                    'tablet'  => '',
                    'mobile'  => '',
                ],
                'blockShapeTopPosition' => '',
                'blockShapeBottomSelect' => '',
                'blockShapeBottomSelectEnableColor' => '',
                'blockShapeBottomSelectColor' => '',
                'blockShapeBottomHeight' => [
                    'type'    => 'px',
                    'desktop' => '',
                    'tablet'  => '',
                    'mobile'  => '',
                ],
                'blockShapeBottomWidth' =>  [
                    'type'    => 'px',
                    'desktop' => '',
                    'tablet'  => '',
                    'mobile'  => '',
                ],
                'blockShapeBottomPosition' => '',

                /*Block Title*/
                'blockComponentTitleEnable'          => true,
                'blockComponentTitle'                => __('Block Title', 'gutentor'),
                'blockComponentTitleTag'             => 'h2',
                'blockComponentTitleAlign'           => 'text-center',
                'blockComponentTitleColorEnable'     => true,
                'blockComponentTitleColor'           => [
                    'hex' => '#111111',
                ],
                'blockComponentTitleTypography'      => [

                    'fontType'   => '',
                    'systemFont' => '',
                    'googleFont' => '',
                    'customFont' => '',

                    'desktopFontSize' => '',
                    'tabletFontSize'  => '',
                    'mobileFontSize'  => '',

                    'fontWeight'        => '',
                    'textTransform'     => '',
                    'fontStyle'         => '',
                    'textDecoration'    => '',
                    'desktopLineHeight' => '',
                    'tabletLineHeight'  => '',
                    'mobileLineHeight'  => '',

                    'desktopLetterSpacing' => '',
                    'tabletLetterSpacing'  => '',
                    'mobileLetterSpacing'  => '',

                ],
                'blockComponentTitleMargin'      => [

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

                ],
                'blockComponentTitlePadding'      => [

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
                ],

                'blockComponentTitleAnimation' =>[
                    'Animation' => 'px',
                    'Delay'     => '',
                    'Speed'     => '',
                    'Iteration' => '',
                ],
                'blockComponentTitleDesignEnable' =>true,
                'blockComponentTitleSeperatorPosition' => 'seperator-bottom',

                /*Block Sub title*/
                'blockComponentSubTitleEnable'          => false,
                'blockComponentSubTitle'                => __('Block Sub Title', 'gutentor'),
                'blockComponentSubTitleTag'             => 'p',
                'blockComponentSubTitleAlign'           => 'text-center',
                'blockComponentSubTitleColorEnable'     => true,
                'blockComponentSubTitleColor'           => [
                    'hex' => '#111111',
                ],
                'blockComponentSubTitleTypography'      => [

                    'fontType'       => '',
                    'systemFont'     => '',
                    'googleFont'     => '',
                    'customFont'     => '',

                    'desktopFontSize'     => '',
                    'tabletFontSize'     => '',
                    'mobileFontSize'     => '',

                    'fontWeight'     => '',
                    'textTransform'  => '',
                    'fontStyle'      => '',
                    'textDecoration' => '',
                    'desktopLineHeight'     => '',
                    'tabletLineHeight'     => '',
                    'mobileLineHeight'     => '',

                    'desktopLetterSpacing'     => '',
                    'tabletLetterSpacing'     => '',
                    'mobileLetterSpacing'     => '',

                ],
                'blockComponentSubTitleMargin'      => [

                    'type'       => 'px',
                    'desktopTop'     => '',
                    'desktopRight'     => '',
                    'desktopBottom'     => '',
                    'desktopLeft'     => '',

                    'tabletTop'     => '',
                    'tabletRight'     => '',
                    'tabletBottom'     => '',
                    'tabletLeft'     => '',

                    'mobileTop'     => '',
                    'mobileRight'  => '',
                    'mobileBottom'      => '',
                    'mobileLeft' => '',

                ],
                'blockComponentSubTitlePadding'      => [

                    'type'       => 'px',
                    'desktopTop'     => '',
                    'desktopRight'     => '',
                    'desktopBottom'     => '',
                    'desktopLeft'     => '',

                    'tabletTop'     => '',
                    'tabletRight'     => '',
                    'tabletBottom'     => '',
                    'tabletLeft'     => '',

                    'mobileTop'     => '',
                    'mobileRight'  => '',
                    'mobileBottom'      => '',
                    'mobileLeft' => '',

                ],
                'blockComponentSubTitleAnimation'      => [

                    'Animation'       => 'px',
                    'Delay'     => '',
                    'Speed'     => '',
                    'Iteration'     => '',

                ],
                'blockComponentSubTitleDesignEnable' =>false,
                'blockComponentSubTitleSeperatorPosition' => 'seperator-bottom',

                /*primary button*/
                'blockComponentPrimaryButtonEnable' => false,
                'blockComponentPrimaryButtonLinkOptions' => [
                    'openInNewTab' => false,
                    'rel' => '',
                ],
                'blockComponentPrimaryButtonColor' => [
                    'enable' => true,
                    'normal' => [
                        'hex' => '#275cf6',
                        'rgb' => array(
                            'r' => '39',
                            'g' => '92',
                            'b' => '246',
                            'a' => '1',
                        )
                    ],
                    'hover' => [
                        'hex' => '#1949d4',
                        'rgb' => [
                            'r' => '25',
                            'g' => '73',
                            'b' => '212',
                            'a' => '1',
                        ]
                    ],
                ],
                'blockComponentPrimaryButtonTextColor' => [
                    'enable' => true,
                    'normal' => [
                        'hex' => '#fff',
                    ],
                    'hover' => '',
                ],
                'blockComponentPrimaryButtonMargin'    => [
                    'type' => 'px',
                    'desktopTop' => '',
                    'desktopRight' => '',
                    'desktopBottom' => '',
                    'desktopLeft' => '',
                    'tabletTop' => '',
                    'tabletRight' => '',
                    'tabletBottom' => '',
                    'tabletLeft' => '',
                    'mobileTop' => '',
                    'mobileRight' => '',
                    'mobileBottom' => '',
                    'mobileLeft' => '',
                ],
                'blockComponentPrimaryButtonPadding'   => [
                    'type' => 'px',
                    'desktopTop' => '12',
                    'desktopRight' => '25',
                    'desktopBottom' => '12',
                    'desktopLeft' => '25',
                    'tabletTop' => '12',
                    'tabletRight' => '25',
                    'tabletBottom' => '12',
                    'tabletLeft' => '25',
                    'mobileTop' => '12',
                    'mobileRight' => '25',
                    'mobileBottom' => '12',
                    'mobileLeft' => '25',
                ],
                'blockComponentPrimaryButtonIconOptions'=> [

                    'position' => 'hide',
                    'size' => '',
                ],
                'blockComponentPrimaryButtonIconMargin' => [
                    'type' => 'px',
                    'desktopTop' => '',
                    'desktopRight' => '',
                    'desktopBottom' => '',
                    'desktopLeft' => '',
                    'tabletTop' => '',
                    'tabletRight' => '',
                    'tabletBottom' => '',
                    'tabletLeft' => '',
                    'mobileTop' => '',
                    'mobileRight' => '',
                    'mobileBottom' => '',
                    'mobileLeft' => '',
                ],
                'blockComponentPrimaryButtonIconPadding' => [
                    'type' => 'px',
                    'desktopTop' => '',
                    'desktopRight' => '',
                    'desktopBottom' => '',
                    'desktopLeft' => '',
                    'tabletTop' => '',
                    'tabletRight' => '',
                    'tabletBottom' => '',
                    'tabletLeft' => '',
                    'mobileTop' => '',
                    'mobileRight' => '',
                    'mobileBottom' => '',
                    'mobileLeft' => '',
                ],
                'blockComponentPrimaryButtonBorder' => [
                    'borderStyle'        => '',
                    'borderTop'          => '',
                    'borderRight'        => '',
                    'borderBottom'       => '',
                    'borderLeft'         => '',
                    'borderColorNormal'  => '',
                    'borderColorHover'   => '',
                    'borderRadiusType'   => 'px',
                    'borderRadiusTop'    => '3',
                    'borderRadiusRight'  => '3',
                    'borderRadiusBottom' => '3',
                    'borderRadiusLeft'   => '3',

                ],
                'blockComponentPrimaryButtonBoxShadow'  => [
                    'boxShadowColor' => '',
                    'boxShadowX' => '',
                    'boxShadowY' => '',
                    'boxShadowBlur' => '',
                    'boxShadowSpread' => '',
                    'boxShadowPosition' => '',
                ],
                'blockComponentPrimaryButtonTypography'=> [
                    'fontType'             => 'system',
                    'systemFont'           => '',
                    'googleFont'           => '',
                    'customFont'           => '',

                    'desktopFontSize'      => '16',
                    'tabletFontSize'       => '16',
                    'mobileFontSize'       => '16',

                    'fontWeight'           => '',
                    'textTransform'        =>'normal',
                    'fontStyle'            => '',
                    'textDecoration'      => '',

                    'desktopLineHeight'    => '',
                    'tabletLineHeight'     => '',
                    'mobileLineHeight'     => '',

                    'desktopLetterSpacing' => '',
                    'tabletLetterSpacing'  => '',
                    'mobileLetterSpacing'  => ''
                ],
                'blockComponentPrimaryButtonIcon' => [

                    'label'             => 'fa-book',
                    'value'             => 'fas fa-book',
                    'code'             => 'f108',
                ],
                'blockComponentPrimaryButtonText'  => __('View More'),
                'blockComponentPrimaryButtonLink'  => __('#'),

                /*Secondary Button*/
                'blockComponentSecondaryButtonEnable' => false,
                'blockComponentSecondaryButtonLinkOptions' => [
                    'openInNewTab' => false,
                    'rel' => '',
                ],
                'blockComponentSecondaryButtonColor' => [
                    'enable' => true,
                    'normal' => [
                        'hex' => '#275cf6',
                        'rgb' => array(
                            'r' => '39',
                            'g' => '92',
                            'b' => '246',
                            'a' => '1',
                        )
                    ],
                    'hover' => [
                        'hex' => '#1949d4',
                        'rgb' => [
                            'r' => '25',
                            'g' => '73',
                            'b' => '212',
                            'a' => '1',
                        ]
                    ],
                ],
                'blockComponentSecondaryButtonTextColor' => [
                    'enable' => true,
                    'normal' => [
                        'hex' => '#fff',
                    ],
                    'hover' => '',
                ],
                'blockComponentSecondaryButtonMargin'    => [
                    'type' => 'px',
                    'desktopTop' => '',
                    'desktopRight' => '',
                    'desktopBottom' => '',
                    'desktopLeft' => '',
                    'tabletTop' => '',
                    'tabletRight' => '',
                    'tabletBottom' => '',
                    'tabletLeft' => '',
                    'mobileTop' => '',
                    'mobileRight' => '',
                    'mobileBottom' => '',
                    'mobileLeft' => '',
                ],
                'blockComponentSecondaryButtonPadding'   => [
                    'type' => 'px',
                    'desktopTop' => '12',
                    'desktopRight' => '25',
                    'desktopBottom' => '12',
                    'desktopLeft' => '25',
                    'tabletTop' => '12',
                    'tabletRight' => '25',
                    'tabletBottom' => '12',
                    'tabletLeft' => '25',
                    'mobileTop' => '12',
                    'mobileRight' => '25',
                    'mobileBottom' => '12',
                    'mobileLeft' => '25',
                ],
                'blockComponentSecondaryButtonIconOptions'=> [
                    'position' => 'hide',
                    'size' => '',
                ],
                'blockComponentSecondaryButtonIconMargin' => [
                    'type' => 'px',
                    'desktopTop' => '',
                    'desktopRight' => '',
                    'desktopBottom' => '',
                    'desktopLeft' => '',
                    'tabletTop' => '',
                    'tabletRight' => '',
                    'tabletBottom' => '',
                    'tabletLeft' => '',
                    'mobileTop' => '',
                    'mobileRight' => '',
                    'mobileBottom' => '',
                    'mobileLeft' => '',
                ],
                'blockComponentSecondaryButtonIconPadding' => [
                    'type' => 'px',
                    'desktopTop' => '',
                    'desktopRight' => '',
                    'desktopBottom' => '',
                    'desktopLeft' => '',
                    'tabletTop' => '',
                    'tabletRight' => '',
                    'tabletBottom' => '',
                    'tabletLeft' => '',
                    'mobileTop' => '',
                    'mobileRight' => '',
                    'mobileBottom' => '',
                    'mobileLeft' => '',
                ],
                'blockComponentSecondaryButtonBorder' => [
                    'borderStyle' => '',
                    'borderTop' => '',
                    'borderRight' => '',
                    'borderBottom' => '',
                    'borderLeft' => '',
                    'borderColorNormal' => '',
                    'borderColorHover' => '',
                    'borderRadiusType' => 'px',
                    'borderRadiusTop' => '3',
                    'borderRadiusRight' => '3',
                    'borderRadiusBottom' => '3',
                    'borderRadiusLeft' => '3',
                ],
                'blockComponentSecondaryButtonBoxShadow'  => [
                    'boxShadowColor' => '',
                    'boxShadowX' => '',
                    'boxShadowY' => '',
                    'boxShadowBlur' => '',
                    'boxShadowSpread' => '',
                    'boxShadowPosition' => '',
                ],
                'blockComponentSecondaryButtonTypography'=> [
                    'fontType'             => 'system',
                    'systemFont'           => '',
                    'googleFont'           => '',
                    'customFont'           => '',

                    'desktopFontSize'      => '16',
                    'tabletFontSize'       => '16',
                    'mobileFontSize'       => '16',

                    'fontWeight'           => '',
                    'textTransform'        =>'normal',
                    'fontStyle'            => '',
                    'textDecoration'      => '',

                    'desktopLineHeight'    => '',
                    'tabletLineHeight'     => '',
                    'mobileLineHeight'     => '',

                    'desktopLetterSpacing' => '',
                    'tabletLetterSpacing'  => '',
                    'mobileLetterSpacing'  => ''
                ],
                'blockComponentSecondaryButtonIcon' => [
                    'label'             => 'fa-book',
                    'value'             => 'fas fa-book',
                    'code'             => 'f108',
                ],
                'blockComponentSecondaryButtonText'  => __('View More','gutentor'),
                'blockComponentSecondaryButtonLink'  => __('#'),

                /*carousel attr*/
                'blockItemsCarouselEnable' => false,
                'blockItemsCarouselDots' => false,
                'blockItemsCarouselDotsTablet' => false,
                'blockItemsCarouselDotsMobile' => false,
                'blockItemsCarouselDotsColor' => [
                    'enable' => false,
                    'normal' => '',
                    'hover'  => ''
                ],
                'blockItemsCarouselDotsButtonBorder' => [
                    'borderStyle'        => 'none',
                    'borderTop'          => '',
                    'borderRight'        => '',
                    'borderBottom'       => '',
                    'borderLeft'         => '',
                    'borderColorNormal'  => '',
                    'borderColorHover'   => '',
                    'borderRadiusType'   => 'px',
                    'borderRadiusTop'    => '',
                    'borderRadiusRight'  => '',
                    'borderRadiusBottom' => '',
                    'borderRadiusLeft'   => ''
                ],
                'blockItemsCarouselDotsButtonHeight' => [],
                'blockItemsCarouselDotsButtonWidth' => [],
                'blockItemsCarouselArrows' => true,
                'blockItemsCarouselArrowsTablet' => true,
                'blockItemsCarouselArrowsMobile' => true,
                'blockItemsCarouselArrowsBgColor' => [
                    'enable' => false,
                    'normal' => '',
                    'hover'  => ''
                ],
                'blockItemsCarouselArrowsTextColor' => [
                    'enable' => false,
                    'normal' => '',
                    'hover'  => ''
                ],
                'blockItemsCarouselInfinite' => false,
                'blockItemsCarouselFade' => false,
                'blockItemsCarouselAutoPlay' => false,
                'blockItemsCarouselSlideSpeed' => 300,
                'blockItemsCarouselCenterMode' => false,
                'blockItemsCarouselCenterPadding' => 60,
                'blockItemsCarouselAutoPlaySpeed' => 1200,
                'blockItemsCarouselResponsiveSlideItem' => [
                    'desktop' => '4',
                    'tablet'=> '3',
                    'mobile' => '2',
                ],
                'blockItemsCarouselResponsiveSlideScroll' => [
                    'desktop' => '4',
                    'tablet'=> '3',
                    'mobile' => '2',
                ],

                'blockItemsCarouselNextArrow' => [
                    'label' => 'fa-angle-right',
                    'value'=> 'fas fa-angle-right',
                    'code' => 'f105',
                ],
                'blockItemsCarouselPrevArrow' => [
                    'label' => 'fa-angle-left',
                    'value'=> 'fas fa-angle-left',
                    'code' => 'f104',
                ],
                'blockItemsCarouselButtonIconSize' => 16,
                'blockItemsCarouselArrowButtonHeight' => [
                    'desktop' => '40',
                    'tablet'  => '30',
                    'mobile'  => '20',
                ],
                'blockItemsCarouselArrowButtonWidth' => [
                    'desktop' => '40',
                    'tablet'  => '30',
                    'mobile'  => '20',
                ],
                'blockItemsCarouselArrowButtonBorder' => [
                    'borderStyle'        => 'none',
                    'borderTop'          => '',
                    'borderRight'        => '',
                    'borderBottom'       => '',
                    'borderLeft'         => '',
                    'borderColorNormal'  => '',
                    'borderColorHover'   => '',
                    'borderRadiusType'   => 'px',
                    'borderRadiusTop'    => '',
                    'borderRadiusRight'  => '',
                    'borderRadiusBottom' => '',
                    'borderRadiusLeft'   => ''
                ],

                /*Image option attr*/
                'blockImageBoxImageOverlayColor' => [
                    'enable' => false,
                    'normal' => '',
                    'hover'  => '',
                ],
                'blockImageBoxMargin' => [
                    'type' => 'px',
                    'desktopTop' => '',
                    'desktopRight' => '',
                    'desktopBottom' => '',
                    'desktopLeft' => '',
                    'tabletTop' => '',
                    'tabletRight' => '',
                    'tabletBottom' => '',
                    'tabletLeft' => '',
                    'mobileTop' => '',
                    'mobileRight' => '',
                    'mobileBottom' => '',
                    'mobileLeft' => '',
                ],
                'blockImageBoxPadding' => [
                    'type' => 'px',
                    'desktopTop' => '',
                    'desktopRight' => '',
                    'desktopBottom' => '',
                    'desktopLeft' => '',
                    'tabletTop' => '',
                    'tabletRight' => '',
                    'tabletBottom' => '',
                    'tabletLeft' => '',
                    'mobileTop' => '',
                    'mobileRight' => '',
                    'mobileBottom' => '',
                    'mobileLeft' => '',
                ],
                'blockFullImageEnable' => false,
                'blockEnableImageBoxWidth' => false,
                'blockImageBoxWidth' =>'',
                'blockEnableImageBoxHeight' => false,
                'blockImageBoxHeight' =>'',
                'blockEnableImageBoxDisplayOptions' => false,
                'blockImageBoxDisplayOptions' => 'normal-image',
                'blockImageBoxBackgroundImageOptions' => [

                    'backgroundImage' => '',

                    'desktopHeight' => '',
                    'tabletHeight'  => '',
                    'mobileHeight'  => '',

                    'backgroundSize'       => '',
                    'backgroundPosition'   => '',
                    'backgroundRepeat'     => '',
                    'backgroundAttachment' => '',
                ],
                'blockEnableImageBoxBorder' => false,
                'blockImageBoxBorder' => [
                    'borderStyle'        => 'none',
                    'borderTop'          => '',
                    'borderRight'        => '',
                    'borderBottom'       => '',
                    'borderLeft'         => '',
                    'borderColorNormal'  => '',
                    'borderColorHover'   => '',
                    'borderRadiusType'   => 'px',
                    'borderRadiusTop'    => '',
                    'borderRadiusRight'  => '',
                    'borderRadiusBottom' => '',
                    'borderRadiusLeft'   => '',
                ],

                /*Item Wrap*/
                'blockItemsWrapMargin' => [
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
                'blockItemsWrapPadding' => [
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
                'blockItemsWrapAnimation' => [
                    'Animation' => 'px',
                    'Delay'     => '',
                    'Speed'     => '',
                    'Iteration' => '',
                ],
            ];
            $default_attr = apply_filters( 'gutentor_common_attr_default_value',$default_attr );
            return $default_attr;
        }

        /**
         * Repeater Common Attr Default Values
         * Default Values
         * @access public
         * @since 1.0.1
         * @return array
         */
        public function get_single_item_common_attrs_default_values(){

            $gutentor_repeater_attr_default_val = [

                /*single item title*/
                'blockSingleItemTitleEnable'           => true,
                'blockSingleItemTitleTag'              => 'h3',
                'blockSingleItemTitleColor'            => [
                    'enable' => false,
                    'normal' => [
                        'hex' => '#111111',
                    ],
                    'hover' => '',
                ],
                'blockSingleItemTitleTypography'       => [
                    'fontType'   => '',
                    'systemFont' => '',
                    'googleFont' => '',
                    'customFont' => '',

                    'desktopFontSize' => '',
                    'tabletFontSize'  => '',
                    'mobileFontSize'  => '',

                    'fontWeight'        => '',
                    'textTransform'     => '',
                    'fontStyle'         => '',
                    'textDecoration'    => '',
                    'desktopLineHeight' => '',
                    'tabletLineHeight'  => '',
                    'mobileLineHeight'  => '',

                    'desktopLetterSpacing' => '',
                    'tabletLetterSpacing'  => '',
                    'mobileLetterSpacing'  => '',

                ],
                'blockSingleItemTitleMargin'           => [

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

                ],
                'blockSingleItemTitlePadding'          => [

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

                ],

                /*single item description*/
                'blockSingleItemDescriptionEnable'     => true,
                'blockSingleItemDescriptionTag'        => 'p',
                'blockSingleItemDescriptionColor'      => [
                    'enable' => false,
                    'normal' => '',
                    'hover' => '',
                ],
                'blockSingleItemDescriptionTypography' => [

                    'fontType'   => '',
                    'systemFont' => '',
                    'googleFont' => '',
                    'customFont' => '',

                    'desktopFontSize' => '',
                    'tabletFontSize'  => '',
                    'mobileFontSize'  => '',

                    'fontWeight'        => '',
                    'textTransform'     => '',
                    'fontStyle'         => '',
                    'textDecoration'    => '',
                    'desktopLineHeight' => '',
                    'tabletLineHeight'  => '',
                    'mobileLineHeight'  => '',

                    'desktopLetterSpacing' => '',
                    'tabletLetterSpacing'  => '',
                    'mobileLetterSpacing'  => '',

                ],
                'blockSingleItemDescriptionMargin'     => [

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
                ],
                'blockSingleItemDescriptionPadding'    => [

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
                ],

                /*single item button*/
                'blockSingleItemButtonEnable'      => false,
                'blockSingleItemButtonLinkOptions' => [
                    'openInNewTab' => false,
                    'rel'          => '',
                ],
                'blockSingleItemButtonColor'       => [
                    'enable' => true,
                    'normal' => [
                        'hex' => '#275cf6',
                        'rgb' => array(
                            'r' => '39',
                            'g' => '92',
                            'b' => '246',
                            'a' => '1',
                        )
                    ],
                    'hover'  => [
                        'hex' => '#1949d4',
                        'rgb' => [
                            'r' => '25',
                            'g' => '73',
                            'b' => '212',
                            'a' => '1',
                        ]
                    ],
                ],
                'blockSingleItemButtonTextColor'   => [
                    'enable' => true,
                    'normal' => [
                        'hex' => '#fff',
                    ],
                    'hover'  => '',
                ],
                'blockSingleItemButtonMargin'      => [
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
                'blockSingleItemButtonPadding'     => [
                    'type'          => 'px',
                    'desktopTop'    => '10',
                    'desktopRight'  => '15',
                    'desktopBottom' => '10',
                    'desktopLeft'   => '15',
                    'tabletTop'     => '10',
                    'tabletRight'   => '15',
                    'tabletBottom'  => '10',
                    'tabletLeft'    => '15',
                    'mobileTop'     => '10',
                    'mobileRight'   => '15',
                    'mobileBottom'  => '10',
                    'mobileLeft'    => '15',
                ],
                'blockSingleItemButtonIconOptions' => [

                    'position' => 'hide',
                    'size'     => '',
                ],
                'blockSingleItemButtonIconMargin'  => [
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
                'blockSingleItemButtonIconPadding' => [
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
                'blockSingleItemButtonBorder'      => [
                    'borderStyle'        => '',
                    'borderTop'          => '',
                    'borderRight'        => '',
                    'borderBottom'       => '',
                    'borderLeft'         => '',
                    'borderColorNormal'  => '',
                    'borderColorHover'   => '',
                    'borderRadiusType'   => 'px',
                    'borderRadiusTop'    => '3',
                    'borderRadiusRight'  => '3',
                    'borderRadiusBottom' => '3',
                    'borderRadiusLeft'   => '3',
                ],
                'blockSingleItemButtonBoxShadow'   => [
                    'boxShadowColor'    => '',
                    'boxShadowX'        => '',
                    'boxShadowY'        => '',
                    'boxShadowBlur'     => '',
                    'boxShadowSpread'   => '',
                    'boxShadowPosition' => '',
                ],
                'blockSingleItemButtonTypography'  => [
                    'fontType'   => 'system',
                    'systemFont' => '',
                    'googleFont' => '',
                    'customFont' => '',

                    'desktopFontSize' => '14',
                    'tabletFontSize'  => '14',
                    'mobileFontSize'  => '14',

                    'fontWeight'     => '',
                    'textTransform'  => 'normal',
                    'fontStyle'      => '',
                    'textDecoration' => '',

                    'desktopLineHeight' => '',
                    'tabletLineHeight'  => '',
                    'mobileLineHeight'  => '',

                    'desktopLetterSpacing' => '',
                    'tabletLetterSpacing'  => '',
                    'mobileLetterSpacing'  => ''
                ],

                /*single item box*/
                'blockSingleItemBoxColor'         => [
                    'enable' => true,
                    'normal' => '',
                    'hover'  => '',
                ],
                'blockSingleItemBoxBorder'        => [
                    'borderStyle'        => 'none',
                    'borderTop'          => '',
                    'borderRight'        => '',
                    'borderBottom'       => '',
                    'borderLeft'         => '',
                    'borderColorNormal'  => '',
                    'borderColorHover'   => '',
                    'borderRadiusType'   => 'px',
                    'borderRadiusTop'    => '',
                    'borderRadiusRight'  => '',
                    'borderRadiusBottom' => '',
                    'borderRadiusLeft'   => '',
                ],
                'blockSingleItemBoxShadowOptions' => [
                    'boxShadowColor'    => '',
                    'boxShadowX'        => '',
                    'boxShadowY'        => '',
                    'boxShadowBlur'     => '',
                    'boxShadowSpread'   => '',
                    'boxShadowPosition' => '',
                ],
                'blockSingleItemBoxMargin'        => [
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
                'blockSingleItemBoxPadding'       => [
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

            return $gutentor_repeater_attr_default_val;
        }

		/**
		 * Repeater Attributes
		 *
		 * @access public
		 * @since 1.0.1
		 * @return array
		 */

		public function add_single_item_common_attrs_default_values( $attr ){

			return array_merge_recursive( $attr, $this->get_single_item_common_attrs_default_values() );
		}

        /**
         * Gutentor Common Dynamic Style
         *
         * @since      1.0.0
         * @package    Gutentor
         * @author     Gutentor <info@gutentor.com>
         *
         * @param array $attributes
         * @return mixed
         */
        public function get_common_css( $attributes ) {

            $attr_default_val       = $this->get_common_attrs_default_values();
            $attributes             = wp_parse_args( $attributes, $attr_default_val );

            $local_dynamic_css            = array();
            $local_dynamic_css['all']     = '';
            $local_dynamic_css['tablet']  = '';
            $local_dynamic_css['desktop'] = '';

            $advBorder      = $attributes['blockComponentBoxBorder'] ? $attributes['blockComponentBoxBorder']  : false;
            $advBoxShadow   = $attributes['blockComponentBoxShadowOptions'] ? $attributes['blockComponentBoxShadowOptions']  : false;
            $adv_Margin     = $attributes['blockComponentMargin'] ? $attributes['blockComponentMargin']  : false;
            $adv_Padding    = $attributes['blockComponentPadding'] ? $attributes['blockComponentPadding']  : false;

            /* global css*/
            if($attributes['blockComponentEnableOverlay']){
                $bg_overlay_color = (($attributes['blockComponentOverlayColor']) && isset($attributes['blockComponentOverlayColor']['rgb']))  ? $attributes['blockComponentOverlayColor']['rgb'] : '';
                $local_dynamic_css['all']     .= '#section-' . $attributes['blockID'] . '.has-gutentor-overlay::after {
                '.gutentor_generate_css('background-color',$bg_overlay_color ? gutentor_rgb_string($bg_overlay_color) :null).'
                }';
            }

            /* Common Advanced Css */
            $local_dynamic_css['all']     .= '#section-' . $attributes['blockID'] . '{
            '.gutentor_advanced_background_css($attributes) . ' 
            '.gutentor_box_four_device_options_css('margin',$adv_Margin).'
            '.gutentor_box_four_device_options_css('padding',$adv_Padding).'
            '.gutentor_border_css($advBorder).'
            '.gutentor_border_shadow_css($advBoxShadow).'
        }';
            $local_dynamic_css['tablet']  .= '#section-' . $attributes['blockID'] . '{
            '.gutentor_box_four_device_options_css('margin',$adv_Margin,'tablet').'
            '.gutentor_box_four_device_options_css('padding',$adv_Padding,'tablet').'
        }';
            $local_dynamic_css['desktop'] .= '#section-' . $attributes['blockID'] . '{
          '.gutentor_box_four_device_options_css('margin',$adv_Margin,'desktop').'
          '.gutentor_box_four_device_options_css('padding',$adv_Padding,'desktop').'
        }';

            /*adv Top shape*/
            $blockShapeTopSelect            = $attributes['blockShapeTopSelect'] ? $attributes['blockShapeTopSelect'] : false;
            $blockShapeTopSelectEnableColor = $attributes['blockShapeTopSelectEnableColor'] ? $attributes['blockShapeTopSelectEnableColor'] : false;
            $blockShapeTopPosition          = $attributes['blockShapeTopPosition'] ? $attributes['blockShapeTopPosition'] : false;

            /*top shape height*/
            $blockShapeTopHeight            = $attributes['blockShapeTopHeight'] ? $attributes['blockShapeTopHeight'] : false;

            /* top shape width*/
            $blockShapeTopWidth             = $attributes['blockShapeTopWidth'] ? $attributes['blockShapeTopWidth'] : false;

            /*fill shape*/
            $local_dynamic_css['all']     .= '#section-' . $attributes['blockID'] . ' .gutentor-block-shape-top svg path{
             '.gutentor_generate_css('fill',(($blockShapeTopSelect && $blockShapeTopSelectEnableColor && isset($attributes['blockShapeTopSelectColor']['rgb'])) ? gutentor_rgb_string($attributes['blockShapeTopSelectColor']['rgb']):null)).'
        }';

            /* top shape height and width*/
            $local_dynamic_css['all']     .= '#section-' . $attributes['blockID'] . ' .gutentor-block-shape-top svg{
            ' . gutentor_responsive_height_width('height',$blockShapeTopHeight) . ' 
            ' . gutentor_responsive_height_width('width',$blockShapeTopWidth) . ' 
        }';

            /*top shape tablet height and width */
            $local_dynamic_css['tablet']     .= '#section-' . $attributes['blockID'] . ' .gutentor-block-shape-top svg{
            ' . gutentor_responsive_height_width('height',$blockShapeTopHeight,'tablet') . ' 
            ' . gutentor_responsive_height_width('width',$blockShapeTopWidth,'tablet') . ' 
        }';

            /*top shape desktop height and width */
            $local_dynamic_css['desktop']     .= '#section-' . $attributes['blockID'] . ' .gutentor-block-shape-top svg{
            ' . gutentor_responsive_height_width('height',$blockShapeTopHeight,'desktop') . ' 
            ' . gutentor_responsive_height_width('width',$blockShapeTopWidth,'desktop') . ' 
        }';


            /*adv Bottom shape*/
            $blockShapeBottomSelect             = $attributes['blockShapeBottomSelect'] ? $attributes['blockShapeBottomSelect'] : false;
            $blockShapeBottomSelectEnableColor  = $attributes['blockShapeBottomSelectEnableColor'] ? $attributes['blockShapeBottomSelectEnableColor'] : false;
            $blockShapeBottomPosition           = $attributes['blockShapeBottomPosition'] ? $attributes['blockShapeBottomPosition'] : false;

            /*bottom shape height*/
            $blockShapeBottomHeight            = $attributes['blockShapeBottomHeight'] ? $attributes['blockShapeBottomHeight'] : false;

            /*bottom shape width*/
            $blockShapeBottomWidth            = $attributes['blockShapeBottomWidth'] ? $attributes['blockShapeBottomWidth'] : false;

            /* fill shape*/
            $local_dynamic_css['all']     .= '#section-' . $attributes['blockID'] . ' .gutentor-block-shape-bottom svg path{
             '.gutentor_generate_css('fill',($blockShapeBottomSelect && $blockShapeBottomSelectEnableColor && isset($attributes['blockShapeBottomSelectColor']['rgb'])) ? gutentor_rgb_string($attributes['blockShapeBottomSelectColor']['rgb']):null).'
        }';

            /* bottom shape height and width*/
            $local_dynamic_css['all']     .= '#section-' . $attributes['blockID'] . ' .gutentor-block-shape-bottom svg{
            ' . gutentor_responsive_height_width('height',$blockShapeBottomHeight) . ' 
            ' . gutentor_responsive_height_width('width',$blockShapeBottomWidth) . '
        }';

            /* bottom shape tablet height and width*/
            $local_dynamic_css['tablet']     .= '#section-' . $attributes['blockID'] . ' .gutentor-block-shape-bottom svg{
            ' . gutentor_responsive_height_width('height',$blockShapeBottomHeight,'tablet') . ' 
            ' . gutentor_responsive_height_width('width',$blockShapeBottomWidth,'tablet') . '
        }';

            /* bottom shape desktop height and width*/
            $local_dynamic_css['desktop']     .= '#section-' . $attributes['blockID'] . ' .gutentor-block-shape-bottom svg{
            ' . gutentor_responsive_height_width('height',$blockShapeBottomHeight,'desktop') . ' 
            ' . gutentor_responsive_height_width('width',$blockShapeBottomWidth,'desktop') . '
        }';

            /*Item Wrap*/
            $item_wrap_Margin     = $attributes['blockItemsWrapMargin'] ? $attributes['blockItemsWrapMargin']  : false;
            $item_wrap_Padding     = $attributes['blockItemsWrapPadding'] ? $attributes['blockItemsWrapPadding']  : false;
            $local_dynamic_css['all']     .= '#section-' . $attributes['blockID'] . ' .gutentor-grid-item-wrap{
            '.gutentor_box_four_device_options_css('margin',$item_wrap_Margin).'
            '.gutentor_box_four_device_options_css('padding',$item_wrap_Padding).'
        }';
            $local_dynamic_css['tablet']  .= '#section-' . $attributes['blockID'] . ' .gutentor-grid-item-wrap{
            '.gutentor_box_four_device_options_css('margin',$item_wrap_Margin,'tablet').'
            '.gutentor_box_four_device_options_css('padding',$item_wrap_Padding,'tablet').'
        }';
            $local_dynamic_css['desktop'] .= '#section-' . $attributes['blockID'] . ' .gutentor-grid-item-wrap{
          '.gutentor_box_four_device_options_css('margin',$item_wrap_Margin,'desktop').'
          '.gutentor_box_four_device_options_css('padding',$item_wrap_Padding,'desktop').'
        }';

            /*Block Title*/
            $title_color_enable = $attributes['blockComponentTitleColorEnable'] ? $attributes['blockComponentTitleColorEnable']  : false;
            $title_typography = $attributes['blockComponentTitleTypography'] ? $attributes['blockComponentTitleTypography']  : false;
            $title_Margin     = $attributes['blockComponentTitleMargin'] ? $attributes['blockComponentTitleMargin']  : false;
            $title_Padding    = $attributes['blockComponentTitlePadding'] ? $attributes['blockComponentTitlePadding']  : false;
            $local_dynamic_css['all'] .= '#section-' . $attributes['blockID'] .' .gutentor-section-title .gutentor-title{
                 '.gutentor_generate_css('color',($title_color_enable && isset($attributes['blockComponentTitleColor'])) ? $attributes['blockComponentTitleColor']['hex']:null).'
                 '.gutentor_typography_options_css($title_typography).'
                 '.gutentor_box_four_device_options_css('margin',$title_Margin).'
                 '.gutentor_box_four_device_options_css('padding',$title_Padding).'
        }';
            $local_dynamic_css['tablet'] .= '#section-' . $attributes['blockID'] . ' .gutentor-section-title .gutentor-title{
              ' . gutentor_typography_options_responsive_css($title_typography,'tablet') . '
                  '.gutentor_box_four_device_options_css('margin',$title_Margin,'tablet').'
                 '.gutentor_box_four_device_options_css('padding',$title_Padding,'tablet').'
        }';
            $local_dynamic_css['desktop'] .= '#section-' . $attributes['blockID'] . ' .gutentor-section-title .gutentor-title{
              ' . gutentor_typography_options_responsive_css($title_typography, 'desktop') . '
               ' . gutentor_box_four_device_options_css('margin', $title_Margin, 'desktop') . '
               ' . gutentor_box_four_device_options_css('padding', $title_Padding, 'desktop') . '
        }';

            /*Imp hook for adding dynamic css*/
            $local_dynamic_css = apply_filters('gutentor_dynamic_css',$local_dynamic_css,$attributes);
            $output = gutentor_get_dynamic_css($local_dynamic_css);
            return $output;
        }
	}
}

/**
 * Return instance of  Gutentor_Block_Base class
 *
 * @since    1.0.0
 */
if( !function_exists( 'gutentor_block_base')){

	function gutentor_block_base() {

		return Gutentor_Block_Base::get_base_instance();
	}
}