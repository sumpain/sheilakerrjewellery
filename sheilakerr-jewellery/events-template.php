<?php
/* Template Name: Events */
get_header(); ?>
<div class="events-page-header">
    <div class="events-page-space">   </div>     
    <h1 class="container fl-heading"><?php echo "Classes"; ?></h1>
</div>
<div class="fl-content-full container">
    <div class="row">
        <div class="fl-content col-md-12">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                        do_action( 'fl_before_post' ); ?>
                        <article <?php post_class( 'fl-post' ); ?> id="fl-post-<?php the_ID(); ?>"<?php FLTheme::print_schema( ' itemscope="itemscope" itemtype="https://schema.org/CreativeWork"' ); ?>>
                            <?php if ( FLTheme::show_post_header() ) : ?>
                            <?php endif; ?>
                            <?php do_action( 'fl_before_post_content' ); ?>
                            <div class="fl-post-content clearfix" itemprop="text">
                                <?php the_content(); ?>
                            </div><!-- .fl-post-content -->
                            <?php do_action( 'fl_after_post_content' ); ?>
                        </article>
                        <?php do_action( 'fl_after_post' );
                endwhile;
            endif;
            ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>