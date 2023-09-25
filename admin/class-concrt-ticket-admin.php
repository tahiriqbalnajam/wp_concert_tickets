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
                'id' => '_custom_date_field',
                'label' => __('Custom Date Field', 'your-text-domain'),
                'desc_tip' => 'true',
                'description' => __('Select a date using the calendar.', 'your-text-domain'),
                'type' => 'date', // This sets the input type to 'date'
                'custom_attributes' => array(
                    'data-datepicker_format' => 'dd/mm/yy', // Change this to your desired date format
                ),
            )
        );
        echo '</div>';
    }

    function save_custom_product_field($product_id) {
        $custom_date = $_POST['_custom_date_field'];
        if (!empty($custom_date)) {
            update_post_meta($product_id, '_custom_date_field', esc_attr($custom_date));
        }

        $main_act = $_POST['_custom_main_act'];
        if (!empty($main_act)) {
            update_post_meta($product_id, '_custom_main_act', esc_attr($main_act));
        }

        $main_act = $_POST['_custom_tour_romoter'];
        if (!empty($main_act)) {
            update_post_meta($product_id, '_custom_tour_romoter', esc_attr($main_act));
        }

        $main_act = $_POST['_custom_presenting_partners'];
        if (!empty($main_act)) {
            update_post_meta($product_id, '_custom_presenting_partners', esc_attr($main_act));
        }


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
