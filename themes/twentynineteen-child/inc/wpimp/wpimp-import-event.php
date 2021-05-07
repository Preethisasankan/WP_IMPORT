<?php
/**
 * To import the data from json.
 * Insert and update event post.
 */
class WPIMP
{
    /**
     * to_get_file_from_json
     *
     * To import the data from json.
     *
     * @since    5.3.2
     *
     * @param    void
     * @return   void
     */
    function to_get_file_from_json()
    {
        $url = get_stylesheet_directory() . '/wpimp-data/data.json';
        if (!file_exists($url)) {
            $this->wpimp_error_log("File doesnot exist");
            return null;
        }
        return json_decode(file_get_contents($url), true);
    }
    /**
     * wpimp_error_log
     *
     * To error log.
     *
     * @since    5.3.2
     *
     * @param    string $text Error text.
     * @return    void
     */
    function wpimp_error_log($text)
    {
        error_log($text);
    }
    /**
     * wpimp_import_data
     *
     * To insert and update event post.
     *
     * @since    5.3.2
     *
     * @param    void
     * @return    void
     */
    function wpimp_import_data()
    {
        $events = $this->to_get_file_from_json();
        /**
         * Check events is not null
         */
        if (!is_array($events) || empty($events)) {
            error_log("No data in json file");
            return null;
        }
        $message_data = $this->wpimp_insert_update_events($events);
        
        $this->wpimp_mail_log($message_data);
        
        
    }
    /**
     * wpimp_insert_update_events
     *
     * To insert and update event post.
     *
     * @since    5.3.2
     *
     * @param    string $events Events.
     * @return    array
     */
    function wpimp_insert_update_events($events)
    {
        
        $updated_post_count = 0;
        $insert_post_count  = 0;
        foreach ($events as $event) {
            if (!array_key_exists('id', $event) || empty($event['id'])) {
                continue;
            }
            $id             = $event['id'];
            $title          = (array_key_exists('title', $event) && isset($event['title'])) ? $event['title']:$event['id'] ;
            $about          = (array_key_exists('about', $event) &&  isset($event['about'])) ? $event['about']:null;
            $timestamp      = (array_key_exists('timestamp', $event) &&  isset($event['timestamp'])) ? $event['timestamp']:null;
            //TODO: $timeformate    = get_option('date_format').' '.get_option('time_format');
            $publish_date   = date('Y-m-d', strtotime($timestamp));
            // TODO: $difference     = the_difference(strtotime($timestamp));
            $poststatus     = (array_key_exists('isActive', $event) &&  ($event['isActive'])) ? "publish": "draft";
            $tags           = (array_key_exists('tags', $event) &&  isset($event['tags'])) ?  implode(",", $event['tags']):null;
           
            /**
             * Check whether event id exists
             */
            $eventId        = $this->wpimp_event_exists($id);
            $wpimp_events   = array(
                'ID'            => $eventId,
                'post_title'    => wp_strip_all_tags($title),
                'post_content'  => $about,
                'post_type'     => 'event',
                'post_date'     => $publish_date,
                'post_status'   => $poststatus
            );
            if ($eventId) {
                $updated_post_count++;
                wp_update_post($wpimp_events);
            } else {
                $insert_post_count++;
                $eventId = wp_insert_post($wpimp_events);
            }
            //Todo:DB error handling 
            
            if ($eventId) {
                wp_set_post_tags($eventId, $tags);
                $acf_fields = array(
                    'id',
                    'organizer',
                    'isActive',
                    'email',
                    'address',
                    'latitude',
                    'longitude'
                );
                foreach ($acf_fields as $acf_field) {
                    $this->wpimp_field_update($acf_field, $event, $eventId);
                }
            }
        }
        return array(
            'count' => count($events),
            'insert_post_count' => $insert_post_count,
            'updated_post_count' => $updated_post_count
        );
        
    }
    /**
     * wpimp_field_update
     *
     * To update acf event meta.
     *
     * @since    5.3.2
     *
     * @param    string $key acf key.
     * @param    array $event event.
     * @param    int $eventId eventId.
     * 
     * @return    void
     */
    function wpimp_field_update($key, $event, $eventId)
    {
        if (array_key_exists($key, $event) && isset($event[$key])) {
            update_field($key, $event[$key],$eventId);
        }
    }
    /**
     * wpimp_field_update
     *
     * Sent import log email to Admin
     *
     * @since    5.3.2
     *
     * @param    array $message_data message_data.
     * @return    void
     */
    function wpimp_mail_log($message_data)
    {
        $message = sprintf('Dear Admin, Event imported Successfully .Total Imported done : %s , %s was inserted, %s was updated. Thanks', $message_data['count'], $message_data['insert_post_count'], $message_data['updated_post_count']);
        wp_mail('logging@agentur-loop.com', 'Event imported successfully', $message);
    }
    /**
     * wpimp_event_exists
     *
     * Check whether event with same ID exists
     *
     * @since    5.3.2
     *
     * @param    void
     * @return   void
     */
    function wpimp_event_exists($id)
    {
        $args = array(
            'post_status' => array(
                'publish',
                'draft'
            ),
            'posts_per_page' => '1',
            'post_type' => 'event',
            
            'meta_query' => array(
                array(
                    'key' => 'id',
                    'value' => $id
                )
            )
        );
        
        $the_query = new WP_Query($args);
        
        if ($the_query->have_posts()):
            while ($the_query->have_posts()):
                $the_query->the_post();
                return get_the_ID();
            endwhile;
        endif;
        return null;
    }
    
    
}

