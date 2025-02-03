<?php
function bb_Testimonials_cpt() {
        $supports = array(
        'title', // post title
        'editor', // post content
        'author', // post author
        'thumbnail', // featured images
        'excerpt', // post excerpt
        'custom-fields', // custom fields
        'comments', // post comments
        'revisions', // post revisions
        'post-formats', // post formats
        );
        $labels = array(
        'name' => _x('Testimonials', 'plural'),
        'singular_name' => _x('Testimonials', 'singular'),
        'menu_name' => _x('Testimonials', 'admin menu'),
        'name_admin_bar' => _x('Testimonials', 'admin bar'),
        'add_new' => _x('Add New', 'add new'),
        'add_new_item' => __('Add New Testimonials'),
        'new_item' => __('New Testimonials'),
        'edit_item' => __('Edit Testimonials'),
        'view_item' => __('View Testimonials'),
        'all_items' => __('All Testimonials'),
        'search_items' => __('Search Testimonials'),
        'not_found' => __('No Testimonials found.'),
        );
        $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'Testimonials'),
        'has_archive' => true,
        'hierarchical' => false,
        );
register_post_type('testimonial', $args);
}
add_action( 'init', 'bb_Testimonials_cpt', 0 );
// Taxonomy For Testimonials
add_action( 'init', 'bb_Testimonials_cpt_taxonomy', 0 );
function bb_Testimonials_cpt_taxonomy() {
 
  $labels = array(
    'name' => _x( 'Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Categories' ),
    'all_items' => __( 'All Categories' ),
    'edit_item' => __( 'Edit Category' ), 
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'menu_name' => __( 'Categories' ),
  );    
 
  register_taxonomy('testimonial-category',array('testimonial'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'type' ),
  ));
}
?>