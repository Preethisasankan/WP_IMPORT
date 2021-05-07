<?php
/**
 * To import the data from json.
 */
function to_get_file_from_json(){
    $url=get_stylesheet_directory().'/wpimp-data/data.json';
    if(!file_exists($url)){
        error_log("File doesnot exist");
        return null;
    } 
    return json_decode(file_get_contents( $url), true);
}

/**
 * insert and update event post.
 */
function wpimp_import_data()
{
    $events=to_get_file_from_json();
    /**
     * Check events is not null
     */
    if(!is_array($events) || empty($events)){
        error_log("No data in json file");
        return null;
    }
   wpimp_insert_post($events);

}
function wpimp_insert_post($events){
    $updated_post_count=0;
    $insert_post_count=0;
    foreach($events as $event){
        if(!array_key_exists('id',$event ) || empty($event['id'])) {
            continue; 
        }
        $id=$event['id'];
        $title=(!array_key_exists('title',$event ) || empty($event['title'])) ? $event['id']: $event['title'];
        $about=(!array_key_exists('about',$event ) || empty($event['about'])) ? null:$event['about'];
        $organizer= (!array_key_exists('organizer',$event ) || empty($event['organizer'])) ? null:$event['organizer'];
        $timestamp= (!array_key_exists('timestamp',$event ) || empty($event['timestamp']))? null:$event['timestamp'];
        $publish_date=date('Y-m-d H:i:s', strtotime($timestamp));
        $poststatus=(!array_key_exists('isActive',$event ) || true ==$event['isActive']) ?"publish":'draft';
        $email= (!array_key_exists('email',$event ) || empty($event['email'])) ? null:$event['email'];
        $address=(!array_key_exists('address',$event ) || empty($event['address'])) ? null:$event['address'];
        $latitude=(!array_key_exists('latitude',$event ) || empty($event['latitude'])) ? null:$event['latitude'];
        $longitude=(!array_key_exists('longitude',$event ) || empty($event['longitude'])) ? null:$event['longitude'];
        $tags=(!array_key_exists('tags',$event ) || empty($event['tags'])) ? null:$event['tags'];
        $tags_converted=implode(",",$tags);
    /**
     * Check whether event id exists
     */
    $eventId=wpimp_event_exists($id);
    $wpimp_events = array(
        'ID'           => $eventId,
        'post_title'    => wp_strip_all_tags( $title ),
        'post_content'  => $about,
        'post_status'   => $poststatus,
        'post_type'     =>'event',
        'post_date'     =>$publish_date,
        // 'tags_input'=> $tags_converted
    );

   if($eventId){  
        $updated_post_count++; 
        wp_update_post($wpimp_events);
   }else{
        $insert_post_count++;
        $eventId = wp_insert_post( $wpimp_events ); 
    }
    //Todo:DB error handling 
   
   if($eventId){
        wp_set_post_tags($eventId,$tags_converted);
        update_field('id', $id,$eventId);
        update_field('organizer', $organizer,$eventId);
        update_field('isActive', $event['isActive'],$eventId);
        update_field('email', $email,$eventId);
        update_field('address', $address,$eventId);
        update_field('latitude', $latitude,$eventId);
        update_field('longitude', $longitude,$eventId);
   } 
}
/** Sent email to Admin */
$message=sprintf('Dear Admin, Event imported Successfully .Total Imported done : %s , %s was inserted, %s was updated. Thanks', count($events),$insert_post_count,$updated_post_count );
wp_mail( 'logging@agentur-loop.com', 'Event imported successfully', $message );
}
/**
 * Check event exists
 */
function wpimp_event_exists($id){
    $args = array(
    'post_status'            => array('publish', 'draft'),
	'posts_per_page'         => '1',
    'post_type'   => 'event',
    
    'meta_query'  => array(
      array(
      'key' => 'id',
      'value' => $id
      )
    )
  );

  $the_query = new WP_Query( $args );
  
   if( $the_query->have_posts() ):
   while( $the_query->have_posts() ) : $the_query->the_post();
       return get_the_ID(); 
   endwhile;
   endif;
 return null;
}





