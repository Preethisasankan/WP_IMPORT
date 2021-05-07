<?php
/*
Plugin Name: Event impotrt
Plugin URI: #
Description: Import events from json. Mail on admin emil when completed.Event Counter on event listing page. REST API for that events
Version: 5.9.5
Author: Preethi Sasankan
Author URI: #
Text Domain: wpimp
Domain Path: /lang
*/
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


        // /**
        //  * Custom Posttype for Events
        //  */
        // require get_stylesheet_directory() . '/inc/wpimp/wpimp-register-custom-posttype.php';
        // /**
        //  * To import the data from json and update event post
        //  */
        // require get_stylesheet_directory() . '/inc/wpimp/wpimp-import-event.php';
        // /**
        //  * To set cronjob for the event
        //  */
        // require get_stylesheet_directory() . '/inc/wpimp/wpimp-cron-job.php';

        foreach ( glob( plugin_dir_path( __FILE__ ) . "inc/*.php" ) as $file ) {
            include_once $file;
        }
    