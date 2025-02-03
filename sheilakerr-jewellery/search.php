<?php 
/**
 *
 * BB Theme Search Results Page with no sidebars. 
 *
 */
 get_header(); ?>
<div class="fl-archive container">
	<div class="row">
		<div id="bb-custom-search-result" class="fl-content col-md-12" itemscope="itemscope" itemtype="http://schema.org/Blog">
			<?php echo '<h3 class="search-query">'.sprintf( _x( 'Search results for: %s', 'Search results title.', 'fl-automator' ), get_search_query() ).'</h3>'; ?>
			<?php if(have_posts()) : ?>
				<?php while(have_posts()) : the_post(); ?>
					<?php 
						echo '<div class="search-article">';
							echo '<h5>' . get_the_title() . '</h5>';
							echo '<p>' . wp_trim_words( get_the_content(), 40 ) . '</p>';
							echo '<a href="'.get_permalink().'">Read More</a>';
						echo '</div>';
					?>
				<?php endwhile; ?>
			<?php else : ?>
				<?php get_template_part('content', 'no-results'); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>