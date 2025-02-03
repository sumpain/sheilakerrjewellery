<?php
Class BB_Customizer_Register{
	function __construct(){
		add_action( 'customize_register', array( $this, 'bb_register_header_customizer' ) );
	}
	/*
	 * Register Our Customizer Stuff Here
	 */
	function bb_register_header_customizer( $wp_customize ) {
		// Add section.
		$wp_customize->add_section( 'custom_headers' , array(
			'title'    => __('Upload Header Images','bb'),
			'panel'    => 'fl-general',
			'priority' => 10
		) );
		// Blog Single Page Section
		$wp_customize->add_setting( 'blog_single_page_title', array(
			 'default'           => __( 'Blog', 'bb' ),
			 'sanitize_callback' => 'sanitize_text'
		) );
		// Add control
		$wp_customize->add_control( new WP_Customize_Control(
		    $wp_customize,
			'blog_single_page_title',
		    array(
		        'label'    => __( 'Blog Single Page Title', 'bb' ),
		        'section'  => 'custom_headers',
		        'settings' => 'blog_single_page_title',
		        'type'     => 'text'
		  	)));
		$wp_customize->add_setting( 'bb_upload_blog_single_img', array(
			 'sanitize_callback' => 'sanitize_text',
		) );
	    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bb_upload_blog_single_img', array(
	        'label'    => __( 'Upload Blog Single Page Image', 'bb'),
	        'section'  => 'custom_headers',
	        'settings' => 'bb_upload_blog_single_img',
	    ) ) );

	    // 404 Page Section
		$wp_customize->add_setting( '404_page_title', array(
			'default'           => __( 'Page Not Found', 'bb' ),
			'sanitize_callback' => 'sanitize_text'
		) );
		$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'404_page_title',
		array(
		    'label'    => __( '404 Page Title', 'bb' ),
		    'section'  => 'custom_headers',
		    'settings' => '404_page_title',
		    'type'     => 'text'
		)));
	    $wp_customize->add_setting( 'bb_upload_404_img', array(
			 'sanitize_callback' => 'sanitize_text',
		) );
	    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bb_upload_404_img', array(
	        'label'    => __( 'Upload 404 Image', 'bb'),
	        'section'  => 'custom_headers',
	        'settings' => 'bb_upload_404_img',
	    ) ) );
	 	// Sanitize text
		function sanitize_text( $text ) {
		    return sanitize_text_field( $text );
		}
	}
}
$bb_customizer = new BB_Customizer_Register;
?>