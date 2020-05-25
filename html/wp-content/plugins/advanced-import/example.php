<?php
function prefix_demo_import_lists(){
	$demo_lists = array(
		'demo1' =>array(
			'title' => __( 'Title', 'text-domain' ),/*Title*/
			'is_premium' => true,/*Premium*/
			'type' => 'gutentor',/*Optional eg gutentor, elementor or other page builders*/
			'author' => __( 'Gutentor', 'gutentor' ),/*Author Name*/
			'keywords' => array( 'about-block', 'about 3' ),/*Search keyword*/
			'categories' => array( 'about' ),/*Categories*/
			'template_url' => 'https://github.com/addonspress/advanced-import/blob/master/online-shop-data.zip?raw=true',/*Json file url */
			'screenshot_url' => '//ts.w.org/wp-content/themes/twentysixteen/screenshot.png?ver=1.6',/*Screenshot of block*/
			'demo_url' => 'https://www.demo-doamin.com/',/*Demo Url*/
			/**/
			'plugins' => array(
				array(
					'name'      => 'Gutentor',
					'slug'      => 'gutentor',
				),
				array(
					'name'      => 'WooCommerce',
					'slug'      => 'woocommerce',
				),
				array(
					'name'      => 'YITH WooCommerce Wishlist',
					'slug'      => 'yith-woocommerce-wishlist',
					'main_file'      => 'init.php',
				),
			)

		),
		'demo2' =>array(
			'title' =>esc_html__('Demo 2', 'text-domain'),
			'type' => 'elementor',/*Optional eg gutentor, elementor or other page builders*/
			'categories' => array('medical'),
			'template_url' => array(
				'content' => 'https://raw.githubusercontent.com/addonspress/advanced-import/master/content.json',
				'options' => 'https://raw.githubusercontent.com/addonspress/advanced-import/master/options.json',
				'widgets' => 'https://raw.githubusercontent.com/addonspress/advanced-import/master/widgets.json'
			),
			'screenshot_url' =>'//ts.w.org/wp-content/themes/twentysixteen/screenshot.png?ver=1.6',
			'demo_url' =>'http://demo.domain.com/demo2/',
			'plugins' => array(
				array(
					'name'      => 'Gutentor',
					'slug'      => 'gutentor',
				),
				array(
					'name'      => 'WooCommerce',
					'slug'      => 'woocommerce',
				),
				array(
					'name'      => 'YITH WooCommerce Wishlist',
					'slug'      => 'yith-woocommerce-wishlist',
					'main_file'      => 'init.php',
				),
			)

		),
		'demo3' =>array(
			'title' =>esc_html__('Demo 3', 'text-domain'),
			'type' => 'gutentor',/*Optional eg gutentor, elementor or other page builders*/
			'categories' => array('education'),
			'template_url' => get_template_directory().'/index.php',
			'screenshot_url' =>'//ts.w.org/wp-content/themes/twentyseventeen/screenshot.png?ver=1.6',
			'demo_url' =>'http://demo.domain.com/medical-circle/'
		),
		'demo4' =>array(
			'title' => __( 'Title', 'text-domain' ),/*Title*/
			'type' => 'gutentor',/*Optional eg gutentor, elementor or other page builders*/
			'author' => __( 'Gutentor', 'gutentor' ),/*Author Name*/
			'keywords' => array( 'about-block', 'about 3' ),/*Search keyword*/
			'categories' => array( 'about' ),/*Categories*/
			'template_url' => 'https://github.com/addonspress/advanced-import/blob/master/online-shop-data.zip?raw=true',/*Json file url */
			'screenshot_url' => '//ts.w.org/wp-content/themes/twentysixteen/screenshot.png?ver=1.6',/*Screenshot of block*/
			'demo_url' => 'https://www.demo-doamin.com/',/*Demo Url*/
			/**/
			'plugins' => array(
				array(
					'name'      => 'Gutentor',
					'slug'      => 'gutentor',
				),
				array(
					'name'      => 'WooCommerce',
					'slug'      => 'woocommerce',
				),
				array(
					'name'      => 'YITH WooCommerce Wishlist',
					'slug'      => 'yith-woocommerce-wishlist',
					'main_file'      => 'init.php',
				),
			)

		),
		'demo5' =>array(
			'title' =>esc_html__('Demo 2', 'text-domain'),
			'type' => 'elementor',/*Optional eg gutentor, elementor or other page builders*/
			'categories' => array('medical'),
			'template_url' => array(
				'content' => 'https://raw.githubusercontent.com/addonspress/advanced-import/master/content.json',
				'options' => 'https://raw.githubusercontent.com/addonspress/advanced-import/master/options.json',
				'widgets' => 'https://raw.githubusercontent.com/addonspress/advanced-import/master/widgets.json'
			),
			'screenshot_url' =>'//ts.w.org/wp-content/themes/twentysixteen/screenshot.png?ver=1.6',
			'demo_url' =>'http://demo.domain.com/demo2/',
			'plugins' => array(
				array(
					'name'      => 'Gutentor',
					'slug'      => 'gutentor',
				),
				array(
					'name'      => 'WooCommerce',
					'slug'      => 'woocommerce',
				),
				array(
					'name'      => 'YITH WooCommerce Wishlist',
					'slug'      => 'yith-woocommerce-wishlist',
					'main_file'      => 'init.php',
				),
			)

		),
		'demo6' =>array(
			'title' =>esc_html__('Demo 3', 'text-domain'),
			'type' => 'gutentor',/*Optional eg gutentor, elementor or other page builders*/
			'categories' => array('education'),
			'template_url' => get_template_directory().'/index.php',
			'screenshot_url' =>'//ts.w.org/wp-content/themes/twentyseventeen/screenshot.png?ver=1.6',
			'demo_url' =>'http://demo.domain.com/medical-circle/'
		),
		'demo7' =>array(
			'title' => __( 'Title', 'text-domain' ),/*Title*/
			'type' => 'gutentor',/*Optional eg gutentor, elementor or other page builders*/
			'author' => __( 'Gutentor', 'gutentor' ),/*Author Name*/
			'keywords' => array( 'about-block', 'about 3' ),/*Search keyword*/
			'categories' => array( 'about' ),/*Categories*/
			'template_url' => 'https://github.com/addonspress/advanced-import/blob/master/online-shop-data.zip?raw=true',/*Json file url */
			'screenshot_url' => '//ts.w.org/wp-content/themes/twentysixteen/screenshot.png?ver=1.6',/*Screenshot of block*/
			'demo_url' => 'https://www.demo-doamin.com/',/*Demo Url*/
			/**/
			'plugins' => array(
				array(
					'name'      => 'Gutentor',
					'slug'      => 'gutentor',
				),
				array(
					'name'      => 'WooCommerce',
					'slug'      => 'woocommerce',
				),
				array(
					'name'      => 'YITH WooCommerce Wishlist',
					'slug'      => 'yith-woocommerce-wishlist',
					'main_file'      => 'init.php',
				),
			)

		),
		'demo8' =>array(
			'title' =>esc_html__('Demo 2', 'text-domain'),
			'type' => 'elementor',/*Optional eg gutentor, elementor or other page builders*/
			'categories' => array('medical'),
			'template_url' => array(
				'content' => 'https://raw.githubusercontent.com/addonspress/advanced-import/master/content.json',
				'options' => 'https://raw.githubusercontent.com/addonspress/advanced-import/master/options.json',
				'widgets' => 'https://raw.githubusercontent.com/addonspress/advanced-import/master/widgets.json'
			),
			'screenshot_url' =>'//ts.w.org/wp-content/themes/twentysixteen/screenshot.png?ver=1.6',
			'demo_url' =>'http://demo.domain.com/demo2/',
			'plugins' => array(
				array(
					'name'      => 'Gutentor',
					'slug'      => 'gutentor',
				),
				array(
					'name'      => 'WooCommerce',
					'slug'      => 'woocommerce',
				),
				array(
					'name'      => 'YITH WooCommerce Wishlist',
					'slug'      => 'yith-woocommerce-wishlist',
					'main_file'      => 'init.php',
				),
			)

		),
		'demo9' =>array(
			'title' =>esc_html__('Demo 3', 'text-domain'),
			'is_premium' => true,/*Premium*/
			'type' => 'gutentor',/*Optional eg gutentor, elementor or other page builders*/
			'categories' => array('education'),
			'template_url' => get_template_directory().'/index.php',
			'screenshot_url' =>'//ts.w.org/wp-content/themes/twentyseventeen/screenshot.png?ver=1.6',
			'demo_url' =>'http://demo.domain.com/medical-circle/'
		),

	);
	return $demo_lists;
}
add_filter('advanced_import_demo_lists','prefix_demo_import_lists');