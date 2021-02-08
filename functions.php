<?php

    function university_files(){
        wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        
        if (strstr($_SERVER['SERVER_NAME'], 'http://amazing-college.local/')) {
            wp_enqueue_script('main-university-javascript', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
        } else {
            wp_enqueue_script('our-vendors-js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'), NULL, '1.0', true);
            wp_enqueue_script('main-university-javascript', get_theme_file_uri('/bundled-assets/scripts.bc49dbb23afb98cfc0f7.js'), NULL, '1.0', true);
            wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.bc49dbb23afb98cfc0f7.css'));
        }
        
        

    }

    add_action('wp_enqueue_scripts', 'university_files');

    function university_features() {
        add_theme_support('title-tag');
    }

    add_action('after_setup_theme', 'university_features');

    function university_adjust_queries($query){
        if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) { // If not on the admin page but are on the event archive page and using the default url based query then...
            $today = date('Ymd'); // Creates a variable that contains the current date
            $query->set('meta_key', 'event_date'); // set the query argument to the meta_key of event_date
            $query->set('orderby', 'meta_value_num'); // set the query argument of orderby to meta_value_num
            $query->set('order', 'ASC');
            $query->set('meta_query', array(
                array( // each custom field needs an array of its own
                    // Only show the event if...
                    'key' => 'event_date', // ... the custom field...
                    'compare' => '>=', // ... Is greater than or equal to...
                    'value' => $today, // ... The current date
                    'type' => 'numeric' // Tells WordPress what kind of values it should look for
                )
            ));
        }
    }
    
    add_action('pre_get_posts', 'university_adjust_queries');