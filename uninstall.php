<?php
/**
 * Project: rich
 * File Name: uninstall.php
 * Author: Zameel Amjed
 * Date: 8/7/2019
 * Time: 11:51 AM
 */
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
	die;
}

global $wpdb;
$table_name      = $wpdb->prefix . 'ambi_products';
$sql             = "ALTER TABLE `{$table_name}` DROP INDEX `serial`;";
$wpdb->query($sql);