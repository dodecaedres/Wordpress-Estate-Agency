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
        if(function_exists('yoast_breadcrumb')):
            yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
        endif;
        ?>
        
        <header class="archive-header">
            <h1><?php echo WPEA::$options['seo']['list_h1']; ?></h1>
        </header><!-- .page-header -->
        
        <?php
        // Defensively check for the key existence
        $search_on_list_template = 0;
        if (isset(WPEA::$options) && 
            isset(WPEA::$options['front']) && 
            isset(WPEA::$options['front']['search_on_list_template']) && 
            WPEA::$options['front']['search_on_list_template'] == 1) {
            $search_on_list_template = 1;
        }

        if($search_on_list_template == 1):
            $widget_args['start_wrapper'] = '<div class="wpea_search_wrapper">';
            $widget_args['end_wrapper'] = '</div>';
            $widget_instance['type'] = WPEA::$options['front']['template_search_type'];

            if(!empty(WPEA::$search['default_title'])):
                $widget_instance['title'] = WPEA::$search['default_title'];
            endif;

            the_widget('WPea_Widget_Search', $widget_instance, $widget_args);
        endif;
        ?>

        <?php wpea_list(); ?>

    </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>
