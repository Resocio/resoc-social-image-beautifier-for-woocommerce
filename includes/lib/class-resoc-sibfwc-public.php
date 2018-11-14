<?php

if ( ! defined( 'ABSPATH' ) ) exit;

require_once plugin_dir_path( __FILE__ ) . 'class-resoc-sibfwc-utils.php';

class Resoc_SIBfWC_Public {

	public function __construct () {
		// Disable Jetpack Open Graph markups
    add_filter( 'jetpack_enable_open_graph', '__return_false' );

    add_action( 'wp_head', array( $this, 'add_opengraph_markups' ) );
  }

  public function add_opengraph_markups() {
    $post_id = get_the_ID();

    if ( get_post_field( 'post_type', $post_id ) !== 'product' ) {
      error_log("Not a product");
      return;
    }

    $image_id = get_post_meta( $post_id, '_thumbnail_id', true );
    if ( ! $image_id ) {
      error_log("No image id");
      return;
    }

    $merchant_id = get_option( Resoc_SIBfWC::OPTION_MERCHANT_ID );

    if ( ! $merchant_id ) {
      error_log("No merchant id");
      return;
    }

    $image_data = wp_get_attachment_metadata( $image_id );
    if ( is_array( $image_data ) ) {
      $image_data['url'] = wp_get_attachment_image_url( $image_id, 'full' );
      echo '<meta name="og:image" value="' .
        "http://resoc.io/api/to-fb?merchant=" . $merchant_id . "&imageUrl=" .
        urlencode( $image_data['url'] ) . '">' . "\n";
      echo '<meta name="og:image:width" value="1200">' . "\n";
      echo '<meta name="og:image:height" value="630">' . "\n";
    }
  }

}
