<?php
// Defines
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );

// Classes
require_once 'classes/class-fl-child-theme.php';
require_once 'classes/customizer.php';
require_once 'classes/testimonial-cpt.php';


// Actions
add_action( 'wp_enqueue_scripts', 'FLChildTheme::enqueue_scripts', 1000 );

// Custom Header Banner for --- Search, Blog Single, 404... pages
function bb_default_pages_header(){    
    // Conditional page titles
    $blog_single_title = get_theme_mod('blog_single_page_title');
    $error_title = get_theme_mod('404_page_title');
    if ( is_category() ) {
        $title = sprintf( __( '%s' ), single_cat_title( '', false ) );
    } elseif ( is_tag() ) {
        $title = 'Posts Tagged: '. sprintf( __( '%s' ), single_tag_title( '', false ) );
    } elseif ( is_single() ) {
        $title = get_the_title();
    } elseif ( is_author() ) {
        $title = 'Posts by: '. sprintf( __( '%s' ), '<span class="vcard">' . get_the_author() . '</span>' );
    } elseif ( is_day() ) {
        $title = sprintf( _x( 'Archive for %s', 'Archive title: day.', 'bb' ), get_the_date() );
    } elseif ( is_month() ) { 
        $title = sprintf( _x( 'Archive for %s', 'Archive title: month.', 'bb' ), single_month_title( ' ', false ) );
    } elseif ( is_year() ) {
        $title = sprintf( _x( 'Archive for %s', 'Archive title: year.', 'bb' ), get_the_time( 'Y' ) );
    }elseif ( is_search() ) {
        $title = 'Search';
    } elseif( is_404() ){
        $title = $error_title;
    }else {
        $title = $blog_single_title;
    }
	if (is_singular('post') || is_archive() || is_404() || is_search() || is_singular('product') ) {
		$class = is_singular('product') ? 'woo-custom-header' : 'pad-lg';
	   $blog_single_image = get_theme_mod('bb_upload_blog_single_img');
	   $search_image = get_theme_mod('bb_upload_404_img');
	   $bg_image = is_404() ? $search_image : $blog_single_image;
	   echo '<div class="default-header-bg pad-lg '.$class.' inner-page-banner">';
		   echo '<div class="default-header-img fl-row-content-wrap" style="background:url('.$bg_image.')">';
		   //	if( !is_singular('product') ) {
				   if( is_shop() ) {
					   echo '<p class="shop-page-info inner-title-info container" style="margin-bottom: 0px; padding-bottom: 0px;"><strong>SHEILA KERR JEWELLERY LTD</strong><br>
					   <span class="inner-header-desc">BEAUTIFUL HANDMADE JEWELLERY</span></p>';
				   }elseif(is_product_category()){
					   //$category = get_queried_object();
					  // echo '<h1 class="default-header-title">'.$category->name.'</h1>';
				   }else{
					   if(is_product()){
					   //	echo '<h1 class="default-header-title">'.$title.'</h1>';
					   }else{
						   //echo '<h1 class="default-header-title">'.$title.'</h1>';
					   }
				   }
			   //}
		   echo '</div>';
		   
		   if (is_singular('post')){
			   echo '<h1 class="container single-inner-page-banner-title">'.$title.'</h1>';
		   }
		   if(is_product_category()){
			   $category = get_queried_object();
			   echo '<h1 class="container single-inner-page-banner-title">'.$category->name.'</h1>';
		   }
		   
	   echo '</div>';
   }
}
add_action('fl_content_open', 'bb_default_pages_header');

// Remove H2 For Events page
function remove_post_title ( $title, $id = null ) {
    if( in_the_loop() && is_singular( 'tribe_events' ) ){
        return '';
    }else{
        return $title;
    }
}
add_filter( 'the_title', 'remove_post_title', 10, 2 );

//  404 image
function  error404_page_info(){
    if( is_404() ){
        echo '<div class=""> <img src="'.FL_CHILD_THEME_URL.'/images/404.png"> </div>';
    }
}
add_action('fl_before_post_content', 'error404_page_info');


/** Woocommerce **/
function woo_shop_before_text(){
    if( is_shop() ){
        echo '<div class="before-shop-info" style="text-align: center;">';
            echo '<h1>Robert Burns Collection</h1>';
            echo "<p>As a passionate Scottish jewellery designer, Sheila Kerr was inspired to create the Robert Burns Jewellery Collection after visiting the Robert Burns Birthplace Museum in Alloway, Ayrshire, Scotland. The Robert Burns Jewellery Collection includes beautiful and romantic jewellery, including Robert Burns pendants, Robert Burns bracelets, Robert Burns rings and Robert Burns earrings, which have all been inspired by the work of Robert Burns. Available in silver and gold, the Robert Burns Jewellery Collection make unique and romantic Valentine's Day, Christmas and Birthday presents, and gifts. You can purchase Sheila’s jewellery via her online Robert Burns gift shop below. Free nationwide delivery is also available.</p>";
        echo '</div>';
    }
}
add_action('woo_before_loop', 'woo_shop_before_text');

function woo_shop_after_text(){
    if( is_shop() ){
        echo '<div class="after-shop-info">';
            echo '<h2>Gift Vouchers</h2>';
            echo "<p>Buying jewellery for someone special can be a daunting prospect, but when you give them a Sheila Kerr Jewellery Ltd gift voucher, you immediately take the stress and worry away from choosing the right jewellery piece.</p>
            <p>All Sheila Kerr Jewellery Ltd gift vouchers are valid for 12 months from the date of purchase online and at Sheila’s studio. Alternatively, if you cannot visit the studio, contact Sheila, and she will organise your purchase and deliver it to you by post free of charge. Free postage is available nationwide.
            </p>
            <p>
            The recipient of the gift voucher can use it to commission a bespoke piece of jewellery if they wish.  Sheila Kerr Jewellery Gift Vouchers can be sent directly to your gift recipient for free throughout the UK via post, and the voucher will arrive beautifully wrapped.
            </p><p>
            Anyone who adores bespoke, designer jewellery will relish the opportunity to choose their favourite pieces from the range at Sheila Kerr Jewellery Ltd.</p>";
        echo '</div>';
     } 
}
add_action('woo_after_loop', 'woo_shop_after_text');

/** Woocommerce **/
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<a class="cart-content" href="<?php echo esc_url(wc_get_cart_url()); ?>" title=""><i class="fas fa-shopping-bag"></i> <span><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'bb'), $woocommerce->cart->cart_contents_count); ?></span> - <span><?php echo WC()->cart->get_cart_total(); ?> </a>
	<?php
	$fragments['a.cart-content'] = ob_get_clean();
	return $fragments;
}
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

function woo_top_info( $atts ) {
    extract( shortcode_atts( array(

    ), $atts ) );

	$cart_item_count = WC()->cart->get_cart_contents_count();
	$cart_count_span = '';
	$html = '';
	$html .= '<div class="top-header-woo-section">';
		$html .= '<ul class="">';
			$html .='<li>'.do_shortcode( '[ti_wishlist_products_counter]' ).'</li>';
			$html .= '<li class="woo-header-cart"><a class="cart-content" href="' . get_permalink( wc_get_page_id( 'cart' ) ) . '"><i class="fas fa-shopping-bag"></i>'.$cart_count_span.' - <span>'.WC()->cart->get_cart_total().'</span></a></li>';
			$html .='<li class="woo-search"><a href="#"><i class="fas fa-search"></i></a></li>';
			if ( is_user_logged_in() ) {
				$html .='<li class="woo-user-info"><a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'" title="'.__('My Account','bb').'"><i class="fas fa-user"></i></a></li>';
			}else{
				$html .='<li class="woo-user-info"><a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'" title="'.__('Login / Register','bb').'"><i class="fas fa-user"></i></a></li>';
			}
		if ( $cart_item_count ) {
			$cart_count_span = '<span class="count">'.$cart_item_count.'</span>';
		}
	
		$html .= '</ul>';
	$html .= '</div>';
	return $html;
}
add_shortcode('woo_top_info', 'woo_top_info');

/** Woo Social Share **/
function sharethis_for_woocommerce() {
	$sb_url = urlencode(get_permalink());
	$sb_title = str_replace( ' ', '%20', get_the_title());
	$sb_thumb = get_the_post_thumbnail();
	$twitterURL = 'https://twitter.com/intent/tweet?text='.$sb_title.'&amp;url='.$sb_url.'&amp;via=wpvkp';
	$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$sb_url;
	$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$sb_url.'&amp;title='.$sb_title;
	if(!empty($sb_thumb)) {
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$sb_url.'&amp;media='.$sb_thumb[0].'&amp;description='.$sb_title;
	}
	else {
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$sb_url.'&amp;description='.$sb_title;
	}
	$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$sb_url.'&amp;media='.$sb_thumb[0].'&amp;description='.$sb_title;
	$gplusURL ='https://plus.google.com/share?url='.$sb_title.''; ?>
	 <div class="woo-social-box">
		<a class="col-1 sbtn s-twitter" href="javascript:void(0)" onclick="javascript:bb_social_share( '<?php  echo $twitterURL; ?>' )"  rel="nofollow"> <i class="fab fa-twitter"></i> </a>
		<a class="col-1 sbtn s-facebook" href="javascript:void(0)"  onclick="javascript:bb_social_share( '<?php  echo $facebookURL; ?>' )" rel="nofollow"><span><i class="fab fa-facebook-f"></i></span></a>
		<a class="col-2 sbtn s-pinterest" href="javascript:void(0)" onclick="javascript:bb_social_share( '<?php  echo $pinterestURL; ?>' )" rel="nofollow"><i class="fab fa-pinterest-p"></i></a>
		<a class="col-2 sbtn s-linkedin" href="javascript:void(0)"  onclick="javascript:bb_social_share( '<?php  echo $linkedInURL; ?>' )" rel="nofollow"><i class="fab fa-linkedin-in"></i></a>
	</div>        
	<?php 
}
add_action( 'woocommerce_share', 'sharethis_for_woocommerce' );

/** Remove Shop Title **/
add_filter( 'woocommerce_show_page_title', 'bb_hide_shop_page_title' ); 
function bb_hide_shop_page_title( $title ) {
   if ( is_shop() || is_product_category() ) $title = false;
   return $title;
}

// Blog Posts Before  add "BLOG"
function bb_blog_generate_rewrite_rules( $wp_rewrite ) {
	$new_rules = array(
	  '(.?.+?)/page/?([0-9]{1,})/?$' => 'index.php?pagename=$matches[1]&paged=$matches[2]',
	  'blog/([^/]+)/?$' => 'index.php?post_type=post&name=$matches[1]',
	  'blog/[^/]+/attachment/([^/]+)/?$' => 'index.php?post_type=post&attachment=$matches[1]',
	  'blog/[^/]+/attachment/([^/]+)/trackback/?$' => 'index.php?post_type=post&attachment=$matches[1]&tb=1',
	  'blog/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
	  'blog/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
	  'blog/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?post_type=post&attachment=$matches[1]&cpage=$matches[2]',     
	  'blog/[^/]+/attachment/([^/]+)/embed/?$' => 'index.php?post_type=post&attachment=$matches[1]&embed=true',
	  'blog/[^/]+/embed/([^/]+)/?$' => 'index.php?post_type=post&attachment=$matches[1]&embed=true',
	  'blog/([^/]+)/embed/?$' => 'index.php?post_type=post&name=$matches[1]&embed=true',
	  'blog/[^/]+/([^/]+)/embed/?$' => 'index.php?post_type=post&attachment=$matches[1]&embed=true',
	  'blog/([^/]+)/trackback/?$' => 'index.php?post_type=post&name=$matches[1]&tb=1',
	  'blog/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&name=$matches[1]&feed=$matches[2]',
	  'blog/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&name=$matches[1]&feed=$matches[2]',
	  'blog/page/([0-9]{1,})/?$' => 'index.php?post_type=post&paged=$matches[1]',
	  'blog/[^/]+/page/?([0-9]{1,})/?$' => 'index.php?post_type=post&name=$matches[1]&paged=$matches[2]',
	  'blog/([^/]+)/page/?([0-9]{1,})/?$' => 'index.php?post_type=post&name=$matches[1]&paged=$matches[2]',
	  'blog/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?post_type=post&name=$matches[1]&cpage=$matches[2]',
	  'blog/([^/]+)(/[0-9]+)?/?$' => 'index.php?post_type=post&name=$matches[1]&page=$matches[2]',
	  'blog/[^/]+/([^/]+)/?$' => 'index.php?post_type=post&attachment=$matches[1]',
	  'blog/[^/]+/([^/]+)/trackback/?$' => 'index.php?post_type=post&attachment=$matches[1]&tb=1',
	  'blog/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
	  'blog/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?post_type=post&attachment=$matches[1]&feed=$matches[2]',
	  'blog/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?post_type=post&attachment=$matches[1]&cpage=$matches[2]',
	);
	$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
  }
  add_action( 'generate_rewrite_rules', 'bb_blog_generate_rewrite_rules' );
  
  function bb_update_post_link( $post_link, $id = 0 ) {
	$post = get_post( $id );
	if( is_object( $post ) && $post->post_type == 'post' ) {
	  return home_url( '/blog/' . $post->post_name );
	}
	return $post_link;
  }
  add_filter( 'post_link', 'bb_update_post_link', 1, 3 );
  
function header_woo_search(){ ?>
	<div class="woo-header-search-form">
		<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
			<div class="form-group">		
  		<?php $args = array(
                    'show_option_all' => esc_html__( 'All Categories', 'woocommerce' ),
                    'hierarchical' => 1,
                    'class' => 'category-select',
                    'echo' => 1,
                    'value_field' => 'slug',
                );
	          $args['taxonomy'] = 'product_cat';
	          $args['name'] = 'product_cat';              
	          $args['class'] = 'category-select';
	          wp_dropdown_categories($args); ?>
			<div class="search-form">
				<label class="screen-reader-text" for="woocommerce-product-search-field"><?php _e( 'Search for:', 'woocommerce' ); ?></label>
				<input type="search" id="woocommerce-product-search-field" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" />
			</div>			
			<div class="search-submit">
				<input type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>" />
			</div>
			</div>
			<input type="hidden" name="post_type" value="product" />
		</form>
		<span class="search-close">X</span>
	</div>
<?php }
add_action('fl_before_top_bar', 'header_woo_search');

add_filter ( 'woocommerce_account_menu_items', 'misha_one_more_link' );
function misha_one_more_link( $menu_links ){
	$new = array( 'order-tracking' => 'Order Tracking' );
 	$menu_links = array_slice( $menu_links, 0, 1, true ) 
	+ $new 
	+ array_slice( $menu_links, 1, NULL, true ); 
 
	return $menu_links;
 
}

/**
 * Register Sidebar
 */
function woo_register_sidebars() {
 
    /* Register first sidebar name Primary Sidebar */
    register_sidebar(
        array(
            'name'          => __( 'Woocommerce Sidebar', 'textdomain' ),
            'id'            => 'woo-sidebar',
            'description' => __( 'Add Woocommerce Widgets', 'textdomain' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h5 class="widget-title">',
            'after_title' => '</h5>'
        )
    );
}
add_action( 'widgets_init', 'woo_register_sidebars' );


add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return '';
}

remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title',10);
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_filter( 'woocommerce_before_shop_loop_item_title', 'bb_prodcut_loop_info', 15 );
function bb_prodcut_loop_info(){
    echo '<div class="product-loop-image">';
        echo woocommerce_get_product_thumbnail();
        echo '<div class="woo-cart-btn">';
            echo woocommerce_template_loop_add_to_cart();
        echo '</div>';
    echo '</div>';  
    echo '<div class="product-description">';
        echo '<strong><a href="'.get_permalink().'">'.get_the_title().'</a></strong>';
        echo woocommerce_template_loop_price();
    echo '</div>';
}

function woo_products_list($atts){
	extract(shortcode_atts(array(
		'link' => 'true',
        'ids' => '',
        'exclude' => '',
	 ), $atts));
	 $orderby = 'name';
	 $order = 'asc';
	 $hide_empty = false;
	 $show_count   = 0;      //set 1 for yes, 0 for no
	 $pad_counts   = 0;      //set 1 for yes, 0 for no
	 $hierarchical = 1;      //set 1 for yes, 0 for no  
     $title        = ''; 
    $inc_ids = !empty($ids) ? explode(",",$ids) : '';
    $exclude = !empty($exclude) ? explode(",",$exclude) : '';
    print_r($inc_ids);
	 $cat_args = array(
		 'orderby'    => $orderby,
		 'order'      => $order,
		 'hide_empty' => $hide_empty,
		 'show_count'   => $show_count,
         'pad_counts'   => $pad_counts,
         'hierarchical' => $hierarchical,
		 'title_li'     => $title,
         'include'       => $inc_ids,
         'exclude'       => $exclude,
		 'child_of' => ''
	 );
	 $html = '';
	 $product_categories = get_terms( 'product_cat', $cat_args );	
	 if( !empty($product_categories) ){
		$html .= '<div class="woo-products-list"><ul>';
		 foreach ($product_categories as $key => $category) {
			$cat_link = ( $link == 'false' ) ? '#'.$category->slug : get_permalink($category->term_id);
			//print_r($category);
            $html .=  '<li cat-id="'.$category->term_id.'"><a href="/product-category/'.$category->slug.'" >'.$category->name.'</a>';
			$sub_cat_args = array(
				'hide_empty' => false,
				'parent' => $category->term_id
			);
			$product_sub_categories = get_terms( 'product_cat', $sub_cat_args );
			if( !empty($product_sub_categories) ){
				$html .=  '<ul>';
					foreach( $product_sub_categories as $child_term ) {
                       
						$cat_link = ( $link == 'false' ) ? '#'.$child_term->slug : get_permalink();
						$html .=  '<li cat-id="'.$child_term->ID.'"><a href="'.$cat_link.'" >'.$child_term->name.'</a>';
						$sub_cat_args = array(
							'hide_empty' => false,
							'parent' => $child_term->term_id
						);
						$product_s_categories = get_terms( 'product_cat', $sub_cat_args );
						if( !empty($product_s_categories) ){
							$html .=  '<ul>';
							foreach( $product_s_categories as $child_term ) {
								$cat_link = ( $link == 'false' ) ? '#'.$child_term->slug : get_permalink();
								$html .=  '<li cat-id="'.$child_term->ID.'"><a href="'.$cat_link.'" >'.$child_term->name.'</a></li>';
							}
							$html .=  '</ul>';
						}
						$html .= '</li>';
					}
					$html .=  '</ul>';				
					$html .=  '</li>';
			} 
			$html .=  '</li>';
		 }
		 $html .=  '</ul></div>';
	 }
	 return $html;
}
add_shortcode( 'woo_cat_list', 'woo_products_list' );



/*** WORDPRESS WEBSITES OPTIMISATION SCRIPT*/
add_action( 'do_feed', 'sp_disable_feed', 1 );
add_action( 'do_feed_rdf', 'sp_disable_feed', 1 );
add_action( 'do_feed_rss', 'sp_disable_feed', 1 );
add_action( 'do_feed_rss2', 'sp_disable_feed', 1 );
add_action( 'do_feed_atom', 'sp_disable_feed', 1 );
add_action( 'do_feed_rss2_comments', 'sp_disable_feed', 1 );
add_action( 'do_feed_atom_comments', 'sp_disable_feed', 1 );

/*** Disable feed link */
function sp_disable_feed() {
    wp_die( sprintf( __( 'This feed does not work, go to our website: <a href="%s">%s</a>', 'beaver-child' ), get_bloginfo( 'url' ), get_bloginfo( 'url' ) ) );
}

remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10 );
remove_action( 'wp_head', 'start_post_rel_link', 10 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );

// all actions related to emojis
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

// disable XML-RPC completely
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );

/** Remove Query Strings **/
function remove_query_strings() {
   if(!is_admin()) {
       add_filter('script_loader_src', 'remove_query_strings_split', 15);
       add_filter('style_loader_src', 'remove_query_strings_split', 15);
   }
}

// Activate CDN paths
/** BB Remove Password Strength Checker Frontend **/
function bb_remove_pwd_checker_frontend() {
    if (!is_admin()) {
        wp_dequeue_script('zxcvbn-async');
        wp_deregister_script('zxcvbn-async');
    }
}
add_action('wp_print_scripts', 'bb_remove_pwd_checker_frontend');

// Capture head
function google_fonts_ds_capture_head() {
    ob_start();
}
add_action('wp_head','google_fonts_ds_capture_head',0);


// Inject display swap to Google Fonts
function google_fonts_ds_inject_display_swap() {
    $head = ob_get_clean();
    $head = str_replace("&#038;display=swap", "", $head);    
    $head = str_replace("googleapis.com/css?family", "googleapis.com/css?display=swap&family", $head);
    $head = preg_replace("/(WebFontConfig\['google'\])(.+[\w])(.+};)/", '$1$2&display=swap$3', $head);
    echo $head;
}
add_action('wp_head','google_fonts_ds_inject_display_swap', PHP_INT_MAX); 
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
// Activated CDN 
add_action('init', 'use_jquery_from_google');
function use_jquery_from_google () {
    if (is_admin()) {
        return;
    }

    global $wp_scripts;
    if (isset($wp_scripts->registered['jquery']->ver)) {
        $ver = $wp_scripts->registered['jquery']->ver;
                $ver = str_replace("-wp", "", $ver);
    } else {
        $ver = '1.12.4';
    }

    wp_deregister_script('jquery');
    wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/$ver/jquery.min.js", false, $ver);
}

add_action( 'wp_enqueue_scripts', 'tin_foil_fontawesome', 11 );
function tin_foil_fontawesome() {
    wp_dequeue_style( 'font-awesome-5' );
    wp_deregister_style( 'font-awesome-5' );
    wp_enqueue_style(  'font-awesome-5', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-1/css/all.min.css' );
}

add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );

function new_loop_shop_per_page( $cols ) {
  $cols = '-1';
  return $cols;
}
?>