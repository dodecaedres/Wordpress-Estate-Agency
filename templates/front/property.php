<?php
/**
 * The template for displaying properties list page
 *
 * @since WP Estate Agency 1.0
 */
get_header(); ?>

    <div id="primary" class="content-area">
        
        <div id="content" class="site-content" role="main">

            <?php
            if ( function_exists( 'yoast_breadcrumb' ) ) :
                yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
            endif;
            ?>
            
            <?php while ( have_posts() ) : the_post();
                $images = wpea_get_field( get_the_ID(), 'images' ); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        <a class="wpea-btn-back" href="javascript:void(0);" onclick="history.back();"><?php _e( 'Back' ); ?></a>
                    </header><!-- .entry-header -->

                    <!-- Galerie -->
                    <?php if ( !empty( $images ) ) : $image_full = wp_get_attachment_image_src( $images[0], 'full' ); $image_detail = wp_get_attachment_image_src( $images[0], 'wpe_detail' ); ?>
                        <div class="wpea-gallery clearfix">
                            <div class="image-preview">
                                <?php if (parent::$options['front']['zoom'] == 1) : ?>
                                    <a id="full" rel="gallery" href="<?php echo $image_full[0]; ?>" class="swipebox"><img id="preview" src="<?php echo $image_detail[0]; ?>" /></a>
                                <?php else : ?>
                                    <img id="preview" src="<?php echo $image_detail[0]; ?>" />
                                <?php endif; ?>
                            </div>
                            <?php if ( ! empty( $images[1] ) ) : ?>
                                <ul id="carousel" class="elastislide-list">
                                    <?php foreach ( $images as $key => $image ) : $image_full = wp_get_attachment_image_src( $images[$key], 'full' ); $image_detail = wp_get_attachment_image_src( $images[$key], 'wpe_detail' ); $image_thumbnail = wp_get_attachment_image_src( $images[$key], 'wpe_thumb' ); ?>
                                        <li data-full="<?php echo $image_full[0]; ?>" data-preview="<?php echo $image_detail[0]; ?>">
                                            <a href="javascript:void(0);"><img src="<?php echo $image_thumbnail[0]; ?>" height="<?php echo $image_thumbnail[2]; ?>" /></a>
                                            <?php if (parent::$options['front']['zoom'] == 1) : ?>
                                                <a href="<?php echo $image_full[0]; ?>" rel="gallery" class="swipebox"></a>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>   
                        <!-- End Galerie -->
                    <?php else : ?>
                        <div class="clearfix"></div>
                    <?php endif; ?>
            
                    <div class="entry-content">
                        
                        <?php $custom_data = wpea_get_custom_data(); ?>
                        
                        <div class="alignright">
                            <?php the_widget( 'WPea_Widget_Group', array( 'id' => 2 ) ); ?>
                            <?php if ( WPea::$options['addthis']['active'] ) : ?>
                                <?php wpea_get_addthis_buttons(); ?>
                            <?php endif; ?>
                        </div><!-- .alignright -->
                        
                        <div class="alignleft">
                            <h2><?php _e( 'Property description' ); ?></h2>
                            <?php echo get_the_content(); ?>
                            <?php if ( wpea_get_field( get_the_ID(), 'reference' ) ) : ?>
                                <p class="wpea-detail-reference"><?php _e( 'Ref. :' ); ?> <?php echo wpea_get_field( get_the_ID(), 'reference' ); ?></p>
                            <?php endif; ?>
                        </div><!-- .alignleft -->
                        
                        <div class="clearfix">
                            <?php wpea_get_energy_diagrams( get_the_ID() ); ?>
                        </div>
                        
                        <div class="wpea-contact-block">
                            <div class="alignleft">
                                <i class="sprite icon-phone"></i>
                                <div><?php _e( 'Are you interested?' ); ?></div>
                                <div><?php echo sprintf( __( 'Contact us at <a href="tel:%1$s">%1$s</a>' ), WPea::$options['agency']['tel'] ); ?></div>
                            </div>
                            <div class="alignright">
                                <div><?php _e( 'Or fill-in ourr contact form' ); ?></div>
                                <a class="fade-out animated" href="<?php echo get_permalink( WPea::$options['front']['contact_page_id'] ); ?>?b=<?php echo wpea_get_field( get_the_ID(), 'reference' ); ?>"><i class="sprite icon-mail"></i><?php _e( 'Contact' ); ?></a>
                            </div>
                            </div>
                        </div>
                            
                    </div><!-- .entry-content -->

                </article><!-- #post-## -->

            <?php endwhile; ?>

        </div><!-- #content -->
        
    </div><!-- #primary -->
    
<?php get_footer();
