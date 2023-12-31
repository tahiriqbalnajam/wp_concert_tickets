<?php


class Concrt_Ticket {

	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {
		if ( defined( 'CONCRT_TICKET_VERSION' ) ) {
			$this->version = CONCRT_TICKET_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'concrt-ticket';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-concrt-ticket-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-concrt-ticket-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-concrt-ticket-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-concrt-ticket-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/exopite-simple-options/exopite-simple-options-framework-class.php';

		$this->loader = new Concrt_Ticket_Loader();

	}

	private function set_locale() {

		$plugin_i18n = new Concrt_Ticket_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_admin_hooks() {

		$plugin_admin = new Concrt_Ticket_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'init', $plugin_admin, 'create_menu', 999 );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'product_type_selector', $plugin_admin, 'add_concert_ticket_product_dropdown', 999 );
		$this->loader->add_action( 'woocommerce_process_product_meta', $plugin_admin, 'save_custom_product_field', 999 );
		//$this->loader->add_action( 'woocommerce_product_options_general_product_data', $plugin_admin, 'custom_product_field', 10 );
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'wh_concert_ticket_admin_custom_js', 10 );
		$this->loader->add_filter( 'woocommerce_product_data_tabs', $plugin_admin, 'woocommerce_product_data_tabs',10, 1 );   
		$this->loader->add_action( 'woocommerce_product_data_panels', $plugin_admin, 'custom_product_field',10 );  

	}

	private function define_public_hooks() {

		$plugin_public = new Concrt_Ticket_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'woocommerce_before_add_to_cart_quantity', $plugin_public, 'before_add_to_cart_quantity', 999 );
		$this->loader->add_action( 'woocommerce_concert_ticket_add_to_cart', $plugin_public, 'woocommerce_simple_add_to_cart', 999 );

		$this->loader->add_action( 'woocommerce_get_stock_html', $plugin_public, 'custom_stock_text', 10, 2 );

		$this->loader->add_action( 'woocommerce_checkout_create_order_line_item', $plugin_public, 'save_custom_order_item_meta_data', 20, 3 );
	

	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
