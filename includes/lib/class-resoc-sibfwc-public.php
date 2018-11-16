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

    $product_url = wp_get_canonical_url( $post_id );
    if ( ! $product_url ) {
      error_log("No product canonical URL");
      return;
    }
    $separator = strpos( $post_url, '?' ) ? '&' : '?';
    $product_url = $product_url . $separator . 'origin=shared_on_facebook';

    $image_url = Resoc_SIBfWC_Utils::get_post_image_url( $post_id );
    if ( ! $image_url ) {
      return;
    }

    $product_page_title = get_the_title( $post_id );

    // OpenGraph (Facebook, LinkedIn...)
    echo '<meta property="og:image" content="' .
      Resoc_SIBfWC_Utils::get_facebook_image_url( $image_url ) .
      '">' . "\n";
    echo '<meta property="og:image:width" content="1200">' . "\n";
    echo '<meta property="og:image:height" content="630">' . "\n";
    echo '<meta property="og:url" content="' . $product_url . '">' . "\n";

    // Twitter card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . htmlspecialchars( $product_page_title ) . '">' . "\n";
    echo '<meta name="twitter:image" content="' .
      Resoc_SIBfWC_Utils::get_twitter_image_url( $image_url ) . '">' . "\n";
  }
}
