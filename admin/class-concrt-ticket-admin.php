<?php

class Concrt_Ticket_Admin {

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/concrt-ticket-admin.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/concrt-ticket-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function create_menu() {
        /**
         * Create a submenu page under Plugins.
         * Framework also add "Settings" to your plugin in plugins list.
         * @link https://github.com/JoeSz/Exopite-Simple-Options-Framework
         */
        $config_submenu = array(

            'type'              => 'menu',                          // Required, menu or metabox
            'id'                => $this->plugin_name,              // Required, meta box id, unique per page, to save: get_option( id )
            'parent'            => 'options-general.php',                   // Parent page of plugin menu (default Settings [options-general.php])
            'submenu'           => true,                            // Required for submenu
            'title'             => 'Ticket Options',               // The title of the options page and the name in admin menu
            'capability'        => 'manage_options',                // The capability needed to view the page
            'plugin_basename'   =>  plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' ),
            'tabbed'            => true,
            // 'multilang'         => false,                        // To turn of multilang, default on.

        );         

        /**
         * Color and Fabrics
        */

        $fields[] = array(
            'title' => 'Select Tour',
            'icon' => 'fa fa-asterisk',
            'name' => 'tour_title',
            'fields' => array(

                array(
                    'type'    => 'group',
                    'id'      => 'tour_title_options',
                    'options' => array(
                        'repeater'          => true,
                        'accordion'         => true,
                        'button_title'      => esc_html__( 'Add Tour Title', 'plugin-name' ),
                        'group_title'       => esc_html__( 'Tour Title', 'plugin-name' ),
                        'limit'             => 50,
                        'sortable'          => true,
                    ),
                    'fields'  => array(

                        array(
                            'id'      => 'tour_title_name',
                            'type'    => 'text',
                            'title'   => esc_html__( 'Tour Title', 'plugin-name' ),
                            'attributes' => array(
                                'data-title' => 'title',
                                'placeholder' => esc_html__( 'Enter Tour Title', 'plugin-name' ),
                            ),
                        )
                   
                    ),

                ),

            ),
        );

        $fields[] = array(
            'title' => 'Main Act ',
            'icon' => 'fa fa-asterisk',
            'name' => 'main_act',
            'fields' => array(

                array(
                    'type'    => 'group',
                    'id'      => 'main_act_options',
                    'options' => array(
                        'repeater'          => true,
                        'accordion'         => true,
                        'button_title'      => esc_html__( 'Add Main Act', 'plugin-name' ),
                        'group_title'       => esc_html__( 'Main Act', 'plugin-name' ),
                        'limit'             => 50,
                        'sortable'          => true,
                    ),
                    'fields'  => array(

                        array(
                            'id'      => 'main_act_name',
                            'type'    => 'text',
                            'title'   => esc_html__( 'Main Act', 'plugin-name' ),
                            'attributes' => array(
                                'data-title' => 'title',
                                'placeholder' => esc_html__( 'Enter Main Act', 'plugin-name' ),
                            ),
                        ),
                        array(
                            'id'      => 'main_act_image',
                            'type'    => 'image',
                            'title'   => 'Select Image',
                        ),
                   
                    ),

                ),

            ),
        );

        $fields[] = array(
            'title' => 'Tour Promoter',
            'icon' => 'fa fa-asterisk',
            'name' => 'tour_promoter',
            'fields' => array(

                array(
                    'type'    => 'group',
                    'id'      => 'tour_promoter_options',
                    'options' => array(
                        'repeater'          => true,
                        'accordion'         => true,
                        'button_title'      => esc_html__( 'Add Tour Promoter', 'plugin-name' ),
                        'group_title'       => esc_html__( 'Tour Promoter', 'plugin-name' ),
                        'limit'             => 50,
                        'sortable'          => true,
                    ),
                    'fields'  => array(

                        array(
                            'id'      => 'tour_promoter_name',
                            'type'    => 'text',
                            'title'   => esc_html__( 'Tour Promoter', 'plugin-name' ),
                            'attributes' => array(
                                'data-title' => 'title',
                                'placeholder' => esc_html__( 'Enter Tour Promoter Name', 'plugin-name' ),
                            ),
                        ),
                        array(
                            'id'      => 'tour_promoter_image',
                            'type'    => 'image',
                            'title'   => 'Select Image',
                        ),
                   
                    ),

                ),

            ),
        );

        
        $fields[] = array(
            'title' => 'Presenting Partners',
            'icon' => 'fa fa-asterisk',
            'name' => 'presenting_partners',
            'fields' => array(

                array(
                    'type'    => 'group',
                    'id'      => 'presenting_partners_options',
                    'options' => array(
                        'repeater'          => true,
                        'accordion'         => true,
                        'button_title'      => esc_html__( 'Add Presenting Partners', 'plugin-name' ),
                        'group_title'       => esc_html__( 'Tour Promoter', 'plugin-name' ),
                        'limit'             => 50,
                        'sortable'          => true,
                    ),
                    'fields'  => array(

                        array(
                            'id'      => 'presenting_partners_name',
                            'type'    => 'text',
                            'title'   => esc_html__( 'Presenting Partners', 'plugin-name' ),
                            'attributes' => array(
                                'data-title' => 'title',
                                'placeholder' => esc_html__( 'Enter Presenting Partners Name', 'plugin-name' ),
                            ),
                        ),
                        array(
                            'id'      => 'presenting_partners_image',
                            'type'    => 'image',
                            'title'   => 'Select Image',
                        ),
                   
                    ),

                ),

            ),
        );
 



        $options_panel = new Exopite_Simple_Options_Framework( $config_submenu, $fields );

    }

}
