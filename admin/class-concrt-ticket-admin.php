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


    public function add_concert_ticket_product_dropdown($types) {
        $types[ 'concert_ticket' ] = __( 'Concert Ticket' );
        return $types;
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
                        array(
                            'id'      => 'tour_promoter_email',
                            'type'    => 'text',
                            'title'   => 'Enter Email-id',
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

    // Define a custom field
    function custom_product_field() {
        global $post;
        $all_options = get_exopite_sof_option($this->plugin_name);    
        
        echo '<div class="options_group">';
        woocommerce_wp_checkbox( array(
            'id'        => '_enable_concert_ticketing',
            'desc'      => __('Enable Concert Ticketing ', 'woocommerce'),
            'label'     => __('Enable Concert Ticketing', 'woocommerce'),
            'desc_tip'  => 'true'
        ));

        if(isset($all_options['main_act_options'])){
            $main_act_names = array();
            foreach ($all_options['main_act_options'] as $option) {
                    $main_act_names[] = $option['main_act_name']; // Add main_act_name to the new array
            }
            $options = array(
                ''        => __( 'Select Main Act', 'woocommerce' ),
            );
            $options = array_merge($options, array_combine($main_act_names, $main_act_names));
            woocommerce_wp_select(
                array(
                    'id'          => '_custom_main_act',
                    'label'       => __( 'Main Act', 'woocommerce' ),
                    'options'     => $options, // Use the updated $options array
                )
            );
        }

        if (isset($all_options['tour_promoter_options'])){
            $tour_promoter_names = array();
            foreach ($all_options['tour_promoter_options'] as $option) {
                    $tour_promoter_names[] = $option['tour_promoter_name']; // Add main_act_name to the new array
            }
            $options = array(
                ''        => __( 'Select Tour Promoter', 'woocommerce' ),
            );
            $options = array_merge($options, array_combine($tour_promoter_names, $tour_promoter_names));
            woocommerce_wp_select(
                array(
                    'id'          => '_custom_tour_romoter',
                    'label'       => __( 'Tour Promoter', 'woocommerce' ),
                    'options'     => $options, // Use the updated $options array
                )
            );
        }

        $tour_promoter_names = array();
        if (isset($all_options['presenting_partners_options'])){
            foreach ($all_options['presenting_partners_options'] as $option) {
                    $tour_promoter_names[] = $option['presenting_partners_name']; // Add main_act_name to the new array
            }
            $options = array(
                ''        => __( 'Select Presenting Partners', 'woocommerce' ),
            );
            $options = array_merge($options, array_combine($tour_promoter_names, $tour_promoter_names));
            woocommerce_wp_select(
                array(
                    'id'          => '_custom_presenting_partners',
                    'label'       => __( 'Presenting Partners', 'woocommerce' ),
                    'options'     => $options, // Use the updated $options array
                )
            );
        }

        woocommerce_wp_text_input(
            array(
                'id' => '_custom_start_date_field',
                'label' => __('Select Sale Start Date', 'woocommerce'),
                //'desc_tip' => 'true',
                //'description' => __('Select a date using the calendar.', 'your-text-domain'),
                'type' => 'datetime-local', // This sets the input type to 'date'

            )
        );
    
        woocommerce_wp_text_input(
            array(
                'id' => '_custom_end_date_field',
                'label' => __('Select Sale End Date', 'woocommerce'),
                'type' => 'datetime-local', // This sets the input type to 'date'
            )
        );

        woocommerce_wp_text_input(array(
            'id' => '_ticket_price',
            'label' => __('Ticket Price', 'woocommerce'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            ),
        ));

        woocommerce_wp_text_input(array(
            'id' => '_ticket_quantity',
            'label' => __('Ticket Quantity', 'woocommerce'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            ),
        ));

        echo '<H4"><b style="padding-left:30px;">Add Venue</b></h4>';
        woocommerce_wp_text_input(
            array(
                'id' => '_custom_venue_name',
                'label' => __('Venue Name', 'woocommerce'),
                'type' => 'text', 
            )
        );
        woocommerce_wp_text_input(
            array(
                'id' => '_custom_venue_street',
                'label' => __('Street Number', 'woocommerce'),
                'type' => 'text',
            )
        );
        woocommerce_wp_text_input(
            array(
                'id' => '_custom_venue_city',
                'label' => __('Venue City', 'woocommerce'),
                'type' => 'text', 
            )
        );
        woocommerce_wp_text_input(
            array(
                'id' => '_custom_venue_zipcode',
                'label' => __('Venue Zipcode', 'woocommerce'),
                'type' => 'text', 
            )
        );  
        echo '</div>';
    }

    function save_custom_product_field($product_id) {
        
        $enable_concert_ticketing = isset( $_POST['_enable_concert_ticketing'] ) ? 'yes' : 'no';
        update_post_meta($product_id, '_enable_concert_ticketing', esc_attr($enable_concert_ticketing));
        
        $ticket_quantity = $_POST['_ticket_quantity'];
        if (!empty($ticket_quantity)) {
            update_post_meta($product_id, '_ticket_quantity', esc_attr($ticket_quantity));
        }

        $ticket_price = $_POST['_ticket_price'];
        if (!empty($ticket_price)) {
            update_post_meta($product_id, '_ticket_price', esc_attr($ticket_price));
        }

        $custom_date = $_POST['_custom_start_date_field'];
        if (!empty($custom_date)) {
            update_post_meta($product_id, '_custom_start_date_field', esc_attr($custom_date));
        }

        $custom_date = $_POST['_custom_end_date_field'];
        if (!empty($custom_date)) {
            update_post_meta($product_id, '_custom_end_date_field', esc_attr($custom_date));
        }

        $main_act = $_POST['_custom_main_act'];
        if (!empty($main_act)) {
            update_post_meta($product_id, '_custom_main_act', esc_attr($main_act));
        }

        $main_act = $_POST['_custom_tour_romoter'];
        if (!empty($main_act)) {
            update_post_meta($product_id, '_custom_tour_promoter', esc_attr($main_act));
        }

        $main_act = $_POST['_custom_presenting_partners'];
        if (!empty($main_act)) {
            update_post_meta($product_id, '_custom_presenting_partners', esc_attr($main_act));
        }

        $venue_name = $_POST['_custom_venue_name'];
        $venue_street = $_POST['_custom_venue_street'];
        $venue_city = $_POST['_custom_venue_city'];
        $venue_zipcode = $_POST['_custom_venue_zipcode'];
        if (!empty($venue_name)) {
            update_post_meta($product_id, '_custom_venue_name', esc_attr($venue_name));
        }
        if (!empty($venue_street)) {
            update_post_meta($product_id, '_custom_venue_street', esc_attr($venue_street));
        }
        if (!empty($venue_city)) {
            update_post_meta($product_id, '_custom_venue_city', esc_attr($venue_city));
        }
        if (!empty($venue_zipcode)) {
            update_post_meta($product_id, '_custom_venue_zipcode', esc_attr($venue_zipcode));
        }
        update_post_meta($product_id, '_custom_venue_address', esc_attr($venue_name.', '.$venue_street.', '.$venue_city.', '.$venue_zipcode));

    }



    public function wh_concert_ticket_admin_custom_js() {

        if ('product' != get_post_type()) :
            return;
        endif;
        ?>
        <script type='text/javascript'>
                jQuery(document).ready(function () {
                jQuery('.product_data_tabs .general_tab').addClass('show_if_concert_ticket').show();
                jQuery('#general_product_data .pricing').addClass('show_if_concert_ticket').show();
                //for Inventory tab
                jQuery('.inventory_options').addClass('show_if_concert_ticket').show();
                jQuery('#inventory_product_data ._manage_stock_field').addClass('show_if_concert_ticket').show();
                jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('show_if_concert_ticket').show();
                jQuery('#inventory_product_data ._sold_individually_field').addClass('show_if_concert_ticket').show();
            });
        </script>
        <?php
    
    }

    public function woocommerce_product_data_tabs($tabs) {
        array_push($tabs['attribute']['class'], 'show_if_concert_ticket');
        array_push($tabs['variations']['class'], 'show_if_concert_ticket');

        $tabs['demo'] = array(
            'label'     => __( 'Concert Ticket', 'concert_ticket' ),
            'target' => 'concert_ticket_options',
            'class'  => 'show_if_concert_ticket',
        );

        return $tabs;
    }


}
