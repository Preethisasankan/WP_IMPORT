<?php
/**
 * 1.1 Custom Posttype for Events.
 * 1.2 To import the data from json and update event post.
 * 1.3 To set cronjob for the event
 * 
 */

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $parenthandle = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}
/**
 * 1.1 Custom Posttype for Events
 */
require get_stylesheet_directory() . '/inc/wpimp/wpimp-register-custom-posttype.php';
/**
 * 1.2 To import the data from json and update event post.
 */
require get_stylesheet_directory() . '/inc/wpimp/wpimp-import-event.php';
/**
 * 1.3 To set cronjob for the event.
 */
require get_stylesheet_directory() . '/inc/wpimp/wpimp-cron-job.php';