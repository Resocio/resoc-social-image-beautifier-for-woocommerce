<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Resoc_SIBfWC {

  const PLUGIN_PREFIX = 'rsibfwc';

  const OPTION_MERCHANT_ID = 'rsibfwc_merchant_id';

  const SETTINGS_FORM = "rsibfwc_settings_form";
  const MENU_SETTINGS = 'rsibfwc_settings_menu';


	/**
	 * The single instance of Resoc_Social_Editor.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Settings class object
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = null;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_version;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_token;

	/**
	 * The main plugin file.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $file;

	/**
	 * The main plugin directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $dir;

	/**
	 * The plugin assets directory.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_dir;

	/**
	 * The plugin assets URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_url;

	/**
	 * Suffix for Javascripts.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $script_suffix;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file = '', $version = '1.0.0' ) {
		$this->_version = $version;
		$this->_token = 'resoc_social_editor';

		// Load plugin environment variables
		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'plugin-assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/plugin-assets/', $this->file ) ) );

		$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		register_activation_hook( $this->file, array( $this, 'install' ) );

		// Load API for generic admin functions
		if ( is_admin() ) {
			new Resoc_Social_Editor_Admin_API();
		}
		else {
			new Resoc_Social_Editor_Public();
		}

		// Handle localisation
		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );
	} // End __construct ()

	/**
	 * Load plugin localisation
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_localisation () {
		load_plugin_textdomain( 'resoc-social-editor', false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_localisation ()

	/**
	 * Load plugin textdomain
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain () {
	    $domain = 'resoc-social-editor';

	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_plugin_textdomain ()

	/**
	 * Main Resoc_Social_Editor Instance
	 *
	 * Ensures only one instance of Resoc_Social_Editor is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Resoc_Social_Editor()
	 * @return Main Resoc_Social_Editor instance
	 */
	public static function instance ( $file = '', $version = '1.0.0' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}
		return self::$_instance;
	} // End instance ()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __clone ()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	} // End __wakeup ()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install ()

	/**
	 * Log the plugin version number.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		update_option( $this->_token . '_version', $this->_version );
	} // End _log_version_number ()




	/**
	 * Returns /www/wordpress/wp-content/uploaded/rse
	 */
	public static function get_files_dir( $post_id = NULL ) {
		$up_dir = wp_upload_dir();
		return $up_dir['basedir'] . '/' .
			Resoc_Social_Editor::PLUGIN_PREFIX . '/' .
			( $post_id ? $post_id . '/' : '' );
	}

	/**
	 * Returns http//somesite.com/blog/wp-content/upload/rse/
	 */
	public static function get_files_url( $post_id ) {
		$up_dir = wp_upload_dir();
		$base_url = $up_dir['baseurl'];
		// Make sure to no duplicate the '/'
		// This is especially important when the base URL is the root directory:
		// When this happens, the generated URL would be
		// "http//somesite.com//fbrfg/" and then "//fbrfg/" when the host name is
		// stripped. But this path is wrong, as it looks like a "same protocol" URL.
		$separator = (substr($base_url, -1) == '/') ? '' : '/';
		return $base_url . $separator .
			Resoc_Social_Editor::PLUGIN_PREFIX . '/' . $post_id . '/';
	}

	public static function get_tmp_dir() {
		return Resoc_Social_Editor::get_files_dir() . 'tmp/';
	}

	public static function remove_directory($directory) {
		foreach( scandir( $directory ) as $v ) {
			if ( is_dir( $directory . '/' . $v ) ) {
				if ( $v != '.' && $v != '..' ) {
					Resoc_Social_Editor::remove_directory( $directory . '/' . $v );
				}
			}
			else {
				unlink( $directory . '/' . $v );
			}
		}
		rmdir( $directory );
	}

	// See https://www.justinsilver.com/technology/writing-to-the-php-error_log-with-var_dump-and-print_r/
	public static function var_error_log( $object = NULL ) {
		ob_start();
		var_dump( $object );
		$contents = ob_get_contents();
		ob_end_clean();
		error_log( $contents );
	}
}
