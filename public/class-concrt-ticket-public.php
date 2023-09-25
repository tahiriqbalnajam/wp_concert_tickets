<?php

class Concrt_Ticket_Public {

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/concrt-ticket-public.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/concrt-ticket-public.js', array( 'jquery' ), $this->version, false );
	}

	public function before_add_to_cart_quantity() {
		global $post;

		$enable_concert_ticketing = get_post_meta( $post->ID, '_enable_concert_ticketing', true );
		if($enable_concert_ticketing == "yes"){
			$main_act = get_post_meta( $post->ID, '_custom_main_act', true );
			$tour_romoter = get_post_meta( $post->ID, '_custom_tour_promoter', true );
			$partners = get_post_meta( $post->ID, '_custom_presenting_partners', true );
			$startdate = get_post_meta( $post->ID, '_custom_start_date_field', true );
			$enddate = get_post_meta( $post->ID, '_custom_end_date_field', true );
			$venue_address = get_post_meta( $post->ID, '_custom_venue_address', true );
			
			echo "<b>Main ACT:</b> ".$main_act."<br>"; 
			echo "<b>Tour Promoter:</b> ".$tour_romoter."<br>"; 
			echo "<b>Presenting Partners:</b> ".$partners."<br>"; 
			echo "<b>Venue Address:</b> ".$venue_address."<br>"; 
			echo "<b>Start Date:</b> ".$startdate."<br>"; 
			echo "<b>End Date:</b> ".$enddate."<br><br><br>"; 
		}
	}
	
	
	

}
