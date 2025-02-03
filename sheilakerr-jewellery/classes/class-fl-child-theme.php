<?php

/**
 * Helper class for child theme functions.
 *
 * @class FLChildTheme
 */
final class FLChildTheme {
    
    /**
	 * Enqueues scripts and styles.
	 *
     * @return void
     */
    static public function enqueue_scripts()
    {
	    wp_enqueue_style( 'fl-child-theme', FL_CHILD_THEME_URL . '/style.css' );
	    //wp_enqueue_style( 'fl-child-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css' );
		//wp_enqueue_script( 'fl-child-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', '', '', true );
		wp_enqueue_script( 'fl-child-scripts', FL_CHILD_THEME_URL . '/js/scripts.js', '', '', true );
    }
}

/** Woocomerce Hooks */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'bb_single_title', 5 );
function bb_single_title() {
    the_title( '<h5 class="product_title entry-title">', '</h5>' );
}