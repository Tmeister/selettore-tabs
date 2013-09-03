<?php
/*
	Plugin Name: Selettore Tabs
	Author: Enrique Chavez
	Author URI: http://enriquechavez.co
	Description: Selettore Tabs is a "must have" section builded it using the latest DMS's improvements you can navigate through the content in a ease way using a beatiful transition effect. No more Custom Post Types, edit the content right in the page thanks to the DMS's live editing.
	Class Name: TmselettoreTabs
	Demo:http://dms.tmeister.net/selettore-tabs
	Version: 1.0
*/

define( 'EC_STORE_URL', 'http://enriquechavez.co' );
//add_action( 'admin_init', 'selettore_check_for_updates' );

function selettore_check_for_updates(){
	$item_name  = "Selettore Tabs";
	$item_key = strtolower( str_replace(' ', '_', $item_name) );

	if( get_option( $item_key."_activated" )){
		if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			include( dirname( __FILE__ ) . '/sections/selettore-tabs/inc/EDD_SL_Plugin_Updater.php' );
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