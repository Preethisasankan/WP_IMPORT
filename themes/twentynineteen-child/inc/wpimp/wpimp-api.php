<?php 
add_action( 'rest_api_init', 'adding_user_meta_rest' );

/**
 * Adds user_meta to rest api 'user' endpoint.
 */

function adding_user_meta_rest() {
    register_rest_field( 'event',
        'organizer',
        array(
            'get_callback'      => 'event_organizer_callback',
            'update_callback'   => null,
            'schema'            => null,
        )
    );
    register_rest_field( 'event',
        'email',
        array(
            'get_callback'      => 'event_email_callback',
            'update_callback'   => null,
            'schema'            => null,
        )
    );
    register_rest_field( 'event',
        'address',
        array(
            'get_callback'      => 'event_address_callback',
            'update_callback'   => null,
            'schema'            => null,
        )
    );
    register_rest_field( 'event',
        'latitude',
        array(
            'get_callback'      => 'event_latitude_callback',
            'update_callback'   => null,
            'schema'            => null,
        )
    );
    
}

/**
 * Return user meta object.
 *
 * @param array $event event.
 * @param string $field_name Registered custom field name ( In this case 'organizer' )
 * @param object $request Request object.
 *
 * @return mixed
 */
function event_organizer_callback( $event, $field_name, $request) {
    return get_field( 'organizer',$event['id'] );
}
/**
 * Return user meta object.
 *
 * @param array $event event.
 * @param string $field_name Registered custom field name ( In this case 'email' )
 * @param object $request Request object.
 *
 * @return mixed
 */
function event_email_callback( $event, $field_name, $request) {
    return get_field( 'email',$event['id'] );
}
/**
 * Return user meta object.
 *
 * @param array $event event.
 * @param string $field_name Registered custom field name ( In this case 'address' )
 * @param object $request Request object.
 *
 * @return mixed
 */
function event_address_callback( $event, $field_name, $request) {
    return get_field( 'address',$event['id'] );
}
/**
 * Return user meta object.
 *
 * @param array $event event.
 * @param string $field_name Registered custom field name ( In this case 'latitude' )
 * @param object $request Request object.
 *
 * @return mixed
 */
function event_latitude_callback( $event, $field_name, $request) {
    return get_field( 'latitude',$event['id'] );
}