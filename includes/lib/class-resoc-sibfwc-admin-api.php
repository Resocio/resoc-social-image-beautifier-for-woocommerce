<?php

require_once ABSPATH . 'wp-admin/includes/plugin.php';

if ( ! defined( 'ABSPATH' ) ) exit;

class Resoc_Social_Editor_Admin_API {

	/**
	 * Constructor function
	 */
	public function __construct () {
    add_action( 'admin_menu',
      array( $this, 'settings_menu' )
    );
    add_action('admin_init',
      array( $this, 'process_settings_form' )
    );
  }

  public function settings_menu() {
    add_options_page(
      'Settings',
      'Resoc Social Image Beautifier for WooCommerce',
      'manage_options',
      Resoc_SIBfWC::MENU_SETTINGS,
      array( $this, 'create_social_editor_settings_page' )
    );
  }

  public function create_social_editor_settings_page() {
    $admin_url = admin_url(
      'options-general.php?page=' . Resoc_SIBfWC::MENU_SETTINGS
    );

    $merchant_id = get_option( Resoc_SIBfWC::OPTION_MERCHANT_ID );

    include_once( plugin_dir_path(__FILE__) . '../../views' . DIRECTORY_SEPARATOR . 'settings.php' );
  }

  public function process_settings_form() {
    if (
      isset( $_REQUEST[Resoc_SIBfWC::SETTINGS_FORM] ) &&
      '1' == $_REQUEST[Resoc_SIBfWC::SETTINGS_FORM]
    ) {
      $merchant_id = $_REQUEST[Resoc_SIBfWC::OPTION_MERCHANT_ID];
      update_option( Resoc_SIBfWC::OPTION_MERCHANT_ID, $merchant_id );
    }
  }

}
