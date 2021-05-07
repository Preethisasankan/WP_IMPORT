<?php 
/**
 * Register a custom post type called "Event".
 */
function wpimp_event_init() {
    $labels = array(
        'name'                  => _x( 'Events', 'Post type general name', 'wpimp' ),
        'singular_name'         => _x( 'Event', 'Post type singular name', 'wpimp' ),
        'menu_name'             => _x( 'Events', 'Admin Menu text', 'wpimp' ),
        'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'wpimp' ),
        'add_new'               => __( 'Add New', 'wpimp' ),
        'add_new_item'          => __( 'Add New Event', 'wpimp' ),
        'new_item'              => __( 'New Event', 'wpimp' ),
        'edit_item'             => __( 'Edit Event', 'wpimp' ),
        'view_item'             => __( 'View Event', 'wpimp' ),
        'all_items'             => __( 'All Events', 'wpimp' ),
        'search_items'          => __( 'Search Events', 'wpimp' ),
        'parent_item_colon'     => __( 'Parent Events:', 'wpimp' ),
        'not_found'             => __( 'No Events found.', 'wpimp' ),
        'not_found_in_trash'    => __( 'No Events found in Trash.', 'wpimp' ),
        'featured_image'        => _x( 'Event Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'wpimp' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'wpimp' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'wpimp' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'wpimp' ),
        'archives'              => _x( 'Event archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'wpimp' ),
        'insert_into_item'      => _x( 'Insert into Event', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'wpimp' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this Event', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'wpimp' ),
        'filter_items_list'     => _x( 'Filter Events list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'wpimp' ),
        'items_list_navigation' => _x( 'Events list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'wpimp' ),
        'items_list'            => _x( 'Events list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'wpimp' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'      => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'event' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );
 
    register_post_type( 'event', $args );
}
 
add_action( 'init', 'wpimp_event_init' );
/**
 * Function to add Tag Selection to event
 */
function wpimp_reg_tag() {
    register_taxonomy_for_object_type('post_tag', 'event');
 }
add_action('init', 'wpimp_reg_tag');
/**
 * 
 */
function get_the_difference($timestamp){

    
    $difference=the_difference($timestamp);
    if($difference>0){
        $daysleft = round((($difference/24)/60)/60)." days remaining";
    }elseif($difference==0){
        $daysleft = "Today";
    }else{
        $daysleft="Past";
    }
        
   
   return $daysleft;

}
function the_difference($timestamp){
    $today = current_time( 'timestamp');
    return (int)$timestamp-$today;

}