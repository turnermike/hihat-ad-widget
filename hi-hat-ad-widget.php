<?php
/**
 * Hi-hat Ad Widget
 *
 * @package   Hi_Hat_Ad_Widget
 * @author    Mike Turner <turner.mike@gmail.com>
 * @license   GPL-2.0+
 * @link      http://hi-hatconsulting.com
 * @copyright 2014 Hi-hat Consulting
 *
 * @wordpress-plugin
 * Plugin Name:       Hi-hat Ad Widget
 * Plugin URI:        http://hi-hatconsulting.com
 * Description:       A plugin to display custom ad widgets.
 * Version:           1.0.0
 * Author:            Mike Turner - Hi-hat Consulting
 * Author URI:        http://hi-hatconsulting.com
 * Text Domain:       hi-hat-ad-widget
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * WordPress-Plugin-Boilerplate: v2.6.1
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

/*
 * @TODO:
 *
 * - replace `class-hi-hat-ad-widget.php` with the name of the plugin's class file
 *
 */
require_once( plugin_dir_path( __FILE__ ) . 'public/class-hi-hat-ad-widget.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 * @TODO:
 *
 * - replace Hi_Hat_Ad_Widget with the name of the class defined in
 *   `class-hi-hat-ad-widget.php`
 */
register_activation_hook( __FILE__, array( 'Hi_Hat_Ad_Widget', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Hi_Hat_Ad_Widget', 'deactivate' ) );

/*
 * @TODO:
 *
 * - replace Hi_Hat_Ad_Widget with the name of the class defined in
 *   `class-hi-hat-ad-widget.php`
 */
add_action( 'plugins_loaded', array( 'Hi_Hat_Ad_Widget', 'get_instance' ) );


