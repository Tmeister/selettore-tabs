<?php
/*
	Plugin Name: Selettore Tabs
	Author: Enrique Chavez
	Author URI: http://enriquechavez.co
	Description: Inline Description
	Class Name: TmselettoreTabs
	Demo:
	Version: 1.0
*/

define( 'EC_STORE_URL', 'http://enriquechavez.co' );
add_action( 'admin_init', 'selettore_check_for_updates' );

function selettore_check_for_updates(){
	$item_name  = "Selettore Tabs";
	$item_key = strtolower( str_replace(' ', '_', $item_name) );

	if( get_option( $item_key."_activated" )){
		if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			include( dirname( __FILE__ ) . '/sections/collapser/inc/EDD_SL_Plugin_Updater.php' );
		}

		$license_key = trim( get_option( $item_key."_license", $default = false ) );

		$edd_updater = new EDD_SL_Plugin_Updater( EC_STORE_URL, __FILE__, array(
				'version' 	=> '1.0',
				'license' 	=> $license_key,
				'item_name' => $item_name,
				'author' 	=> 'Enrique Chavez'
			)
		);
	}
}