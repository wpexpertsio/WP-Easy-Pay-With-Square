<?php
/**
 * Plugin Name: WP Easy Pay 
 * Plugin URI: https://wpexperts.io/products/
 * Description: Easily collect payments for Simple Payment or donations online without coding it yourself or hiring a developer. Skip setting up a complex shopping cart system.
 * Author: Wpexperts
 * Author URI: https://wpexperts.io/
 * Version: 1.0
 * Text Domain: wp-easy-pay
 * License: GPLv2 or later
 */
 
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;


define("WPEP_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("WPEP_PLUGIN_URL", plugin_dir_url(__FILE__));

/**
 * include square lib
 */
require_once( WPEP_PLUGIN_PATH . 'lib/square-sdk/autoload.php' );

/**
 * wp square class
 */
require_once( WPEP_PLUGIN_PATH . 'includes/wpep-class.php' );
new WPEP_Settings();

/**
 * ap square form
 */
require_once( WPEP_PLUGIN_PATH . 'includes/wpep-form-class.php' );
new WPEP_Form();
