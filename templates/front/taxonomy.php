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
            if( function_exists( 'yoast_breadcrumb' ) ):
                yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
            endif;
            ?>
            
            <header class="archive-header">
                <h1><?php single_term_title(); ?> : vente et achat immobilier</h1>
            </header><!-- .page-header -->
            
            <?php
            wpea_list(
                array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'property_type',
                            'field' => 'slug',
                            'terms' => get_query_var( 'term' )
                        ),
                    ),
                )
            ); ?>
            
        </div><!-- #content -->
        
    </div><!-- #primary -->
    
<?php get_footer();
