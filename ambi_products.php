<?php
/**
 * Plugin Name: Ambi Products
 * Plugin URI: http://ambitiousdevelopers.com
 * Description: Add products with categories and geotags and display in a map or embed to section pages using shortcodes
 * Version: 1.5
 * Author: Zameel Amjed
 * Author URI: https://www.linkedin.com/in/zameel-amjed/
 */


define( 'AMBI_PRODUCTS', plugin_dir_path( __FILE__ ) );
require_once( AMBI_PRODUCTS . 'Ambi_Products_Options.php' );
require_once( AMBI_PRODUCTS . 'Ambi_Products_Keys.php' );
require_once( AMBI_PRODUCTS . 'Ambi_Add_Products.php' );
require_once( AMBI_PRODUCTS . 'Ambi_Display_Products.php' );
require_once( AMBI_PRODUCTS . 'print_map.php' );

function ambi_create_table(){
	global $wpdb;

$charset_collate = $wpdb->get_charset_collate();
$table_name = $wpdb->prefix . 'ambi_products';
$sql = "CREATE TABLE $table_name (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `serial` VARCHAR(50) NOT NULL UNIQUE,
  `category` varchar(256) NOT NULL,
  `location` varchar(256) NOT NULL,
  `item_name` varchar(256),
  `status` varchar(55) DEFAULT 'Y' NOT NULL,
  `long` varchar(256) DEFAULT '',
  `lat` varchar(256) DEFAULT '',
  `image` varchar(256) DEFAULT '',
  PRIMARY KEY  (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}


register_activation_hook( __FILE__, 'ambi_create_table' );