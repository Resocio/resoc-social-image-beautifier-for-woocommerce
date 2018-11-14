<?php
/*
 * Plugin Name: Resoc Social Image Beautifier for WooCommerce
 * Version: 0.0.1
 * Plugin URI: https://resoc.io/wordpress
 * Description: Beautiful product images on social networks
 * Author: Philippe Bernard
 * Author URI: https://resoc.io/
 * Requires at least: 4.0
 * Tested up to: 4.9.8
 *
 * Text Domain: resoc-social-editor
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author phbernard
 * @since 0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-resoc-sibfwc.php' );

// Load plugin libraries
require_once( 'includes/lib/class-resoc-sibfwc-admin-api.php' );
require_once( 'includes/lib/class-resoc-sibfwc-public.php' );

/**
 * Returns the main instance of Resoc_Social_Editor to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Resoc_Social_Editor
 */
function Resoc_Social_Editor () {
	$instance = Resoc_SIBfWC::instance( __FILE__, '0.0.1' );

	return $instance;
}

Resoc_Social_Editor();
