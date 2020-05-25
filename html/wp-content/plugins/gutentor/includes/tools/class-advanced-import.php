<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Gutentor_Advanced_Import_Server' ) ) {
	/**
	 * Advanced Import
	 * @package Gutentor
	 * @since 1.0.1
	 *
	 */
	class Gutentor_Advanced_Import_Server extends WP_Rest_Controller {

		/**
		 * Rest route namespace.
		 *
		 * @var Gutentor_Advanced_Import_Server
		 */
		public $namespace = 'gutentor-advanced-import/';

		/**
		 * Rest route version.
		 *
		 * @var Gutentor_Advanced_Import_Server
		 */
		public $version = 'v1';

		/**
		 * Initialize the class
		 */
		public function run() {
			add_action( 'rest_api_init', array( $this, 'register_routes' ) );

            /*Install and Activate Template Library*/
            add_action( 'wp_ajax_install_activate_template_library', array( $this, 'install_activate_template_library' ) );
        }

		/**
		 * Register REST API route
		 */
		public function register_routes() {
			$namespace = $this->namespace . $this->version;

			register_rest_route(
				$namespace,
				'/fetch_templates',
				array(
					array(
						'methods'	=> \WP_REST_Server::READABLE,
						'callback'	=> array( $this, 'fetch_templates' ),
					),
				)
			);

			register_rest_route(
				$namespace,
				'/import_template',
				array(
					array(
						'methods'	=> \WP_REST_Server::READABLE,
						'callback'	=> array( $this, 'import_template' ),
						'args'		=> array(
							'url'	=> array(
								'type'        => 'string',
								'required'    => true,
								'description' => __( 'URL of the JSON file.', 'gutentor' ),
							),
						),
					),
				)
			);
		}

		/**
		 * Function to fetch templates.
		 *
		 * @return array|bool|\WP_Error
		 */
		public function fetch_templates( \WP_REST_Request $request ) {
			if ( ! current_user_can( 'edit_posts' ) ) {
				return false;
			}

            $templates_list = array();

			if( !function_exists('run_gutentor_template_library') ){
                /*if gutentor template library is not installed
            fetch template library data from live*/
                $url = 'https://www.demo.gutentor.com/wp-json/gutentor-tlapi/v1/fetch_templates/';
                $body_args = [
                    /*API version*/
                    'api_version' => wp_get_theme()['Version'],
                    /*lang*/
                    'site_lang' => get_bloginfo( 'language' ),
                ];
                $raw_json = wp_safe_remote_get( $url, [
                    'timeout' => 100,
                    'body' => $body_args,
                ] );

                if ( ! is_wp_error( $raw_json ) ) {
                    $demo_server = json_decode( wp_remote_retrieve_body( $raw_json ), true );
                    if (json_last_error() === JSON_ERROR_NONE) {
                        if( is_array( $demo_server )){
                            $templates_list = $demo_server;
                        }
                    }
                }
            }
			else{
                /*if gutentor template library is installed
                fetch template library data from the plugin gutentor-template-library
                special hooks for gutentor-template-library plugin*/
                $templates_list = apply_filters( 'gutentor_advanced_import_gutentor_template_library', array() );
            }

            $templates = apply_filters( 'gutentor_advanced_import_templates', $templates_list );

            return rest_ensure_response( $templates );
		}

		/**
		 * Function to fetch template JSON.
		 *
		 * @return array|bool|\WP_Error
		 */
		public function import_template( $request ) {
			if ( ! current_user_can( 'edit_posts' ) ) {
				return false;
			}

			$url = $request->get_param( 'url' );
			if ( $url ) {
				/*TODO: Rest API */
				$body_args = [
					/*API version*/
					'api_version' => GUTENTOR_VERSION,
					/*lang*/
					'site_lang' => get_bloginfo( 'language' ),
				];
				$raw_json = wp_safe_remote_get( $url, [
					'timeout' => 100,
					'body' => $body_args,
				] );

				if ( ! is_wp_error( $raw_json ) ) {
					$obj = json_decode( wp_remote_retrieve_body( $raw_json ) );

					if ( $obj ) {
						return rest_ensure_response( $obj );
					}
				}
			}
			return false;
		}

        /**
         * Install and Activate Template Library
         * @since 1.1.5
         *
         * @return array|bool|\WP_Error
         */
		public function install_activate_template_library(){

            check_ajax_referer( 'gutentorNonce', 'security' );

            $slug   = GUTENTOR_RECOMMENDED_TEMPLATE_LIBRARY_SLUG;
            $plugin = GUTENTOR_RECOMMENDED_TEMPLATE_LIBRARY_PLUGIN;

            $status = array(
                'install' => 'plugin',
                'slug'    => sanitize_key( wp_unslash( $slug ) ),
            );

            if ( is_plugin_active_for_network( $plugin ) || is_plugin_active( $plugin ) ) {
                // Plugin is activated
                wp_send_json_success( $status );
            }
            if ( ! current_user_can( 'install_plugins' ) ) {
                $status['errorMessage'] = __( 'Sorry, you are not allowed to install plugins on this site.', 'gutentor' );
                wp_send_json_error( $status );
            }

            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

            // Looks like a plugin is installed, but not active.
            if ( file_exists( WP_PLUGIN_DIR . '/' . $slug ) ) {
                $plugin_data          = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
                $status['plugin']     = $plugin;
                $status['pluginName'] = $plugin_data['Name'];

                if ( current_user_can( 'activate_plugin', $plugin ) && is_plugin_inactive( $plugin ) ) {
                    $result = activate_plugin( $plugin );

                    if ( is_wp_error( $result ) ) {
                        $status['errorCode']    = $result->get_error_code();
                        $status['errorMessage'] = $result->get_error_message();
                        wp_send_json_error( $status );
                    }

                    wp_send_json_success( $status );
                }
            }

            $api = plugins_api(
                'plugin_information',
                array(
                    'slug'   => sanitize_key( wp_unslash( $slug ) ),
                    'fields' => array(
                        'sections' => false,
                    ),
                )
            );

            if ( is_wp_error( $api ) ) {
                $status['errorMessage'] = $api->get_error_message();
                wp_send_json_error( $status );
            }

            $status['pluginName'] = $api->name;

            $skin     = new WP_Ajax_Upgrader_Skin();
            $upgrader = new Plugin_Upgrader( $skin );
            $result   = $upgrader->install( $api->download_link );

            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                $status['debug'] = $skin->get_upgrade_messages();
            }

            if ( is_wp_error( $result ) ) {
                $status['errorCode']    = $result->get_error_code();
                $status['errorMessage'] = $result->get_error_message();
                wp_send_json_error( $status );
            } elseif ( is_wp_error( $skin->result ) ) {
                $status['errorCode']    = $skin->result->get_error_code();
                $status['errorMessage'] = $skin->result->get_error_message();
                wp_send_json_error( $status );
            } elseif ( $skin->get_errors()->get_error_code() ) {
                $status['errorMessage'] = $skin->get_error_messages();
                wp_send_json_error( $status );
            } elseif ( is_null( $result ) ) {
                require_once( ABSPATH . 'wp-admin/includes/file.php' );
                WP_Filesystem();
                global $wp_filesystem;

                $status['errorCode']    = 'unable_to_connect_to_filesystem';
                $status['errorMessage'] = __( 'Unable to connect to the filesystem. Please confirm your credentials.', 'gutentor' );

                // Pass through the error from WP_Filesystem if one was raised.
                if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->get_error_code() ) {
                    $status['errorMessage'] = esc_html( $wp_filesystem->errors->get_error_message() );
                }

                wp_send_json_error( $status );
            }

            $install_status = install_plugin_install_status( $api );

            if ( current_user_can( 'activate_plugin', $install_status['file'] ) && is_plugin_inactive( $install_status['file'] ) ) {
                $result = activate_plugin( $install_status['file'] );

                if ( is_wp_error( $result ) ) {
                    $status['errorCode']    = $result->get_error_code();
                    $status['errorMessage'] = $result->get_error_message();
                    wp_send_json_error( $status );
                }
            }

            wp_send_json_success( $status );
        }

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
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'gutentor' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'gutentor' ), '1.0.0' );
		}
	}

}
Gutentor_Advanced_Import_Server::get_instance()->run();