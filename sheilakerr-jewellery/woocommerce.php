<?php get_header(); 
if(is_shop() || is_product_category()){
	$class="col-md-9";
}else{
	$class="col-md-12";
}
if(is_shop()){
?>
<div class="woo-before-loop-content">	
	<div class="fl-row">
		<div class="container">
			<?php do_action('woo_before_loop'); ?>
		</div>
	</div>
</div>
<?php } ?>
<div class="woo-page-wrapper">
	<div class="container">
		<div class="row">
			<div class="fl-content">
				<?php if ( is_active_sidebar( 'woo-sidebar' ) && is_shop() || is_product_category() ) { ?>
				<div class="col-md-3">
					<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'twentyseventeen' ); ?>">
					<?php dynamic_sidebar( 'woo-sidebar' ); ?>
					</aside><!-- #secondary -->
				</div>
				<?php } ?>
				<div class="<?php echo $class; ?>">
					<?php woocommerce_content(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(is_shop()){ ?>
<div class="woo-after-loop-content">	
	<div class="fl-row">
		<div class="container">
			<?php do_action('woo_after_loop'); ?>
		</div>
	</div>
<div>
<?php } ?>
<?php get_footer(); ?>