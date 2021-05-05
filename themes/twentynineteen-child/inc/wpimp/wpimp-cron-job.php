<?php
/**
 * Cron Job to run the import
 */
function wpimp_custom_cron_schedule( $schedules ) {
    $schedules['every_six_hours'] = array(
        'interval' => 21600, // Every 6 hours
        'display'  => __( 'Every 6 hours' ),
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'wpimp_custom_cron_schedule' );
//Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'wpimp_cron_hook' ) ) {
    wp_schedule_event( time(), 'every_six_hours', 'wpimp_cron_hook' );
}

///Hook into that action that'll fire every six hours
add_action( 'wpimp_cron_hook', 'wpimp_cron_function');
//create your function, that runs on cron
function wpimp_cron_function() {
        wpimp_import_data();
}

add_action( 'wpimp_cron_hook', 'wpimp_function');
function wpimp_function() {
wp_mail( 'logging@agentur-loop.com', 'Event imported successfully', 'Event imported successfully' );
}