<?php 
function university_post_types(){
        //Home Slider Type
        register_post_type('homeslider', array(
            'supports' => array('title'),
            'rewrite' => array('slug' => 'homesliders'),
            'has_archive' => true,
            'public' => true,
            'show_in_rest' => true,
            'labels' => array(
                    'name' => 'Homeslider',
                    'add_new_item' => 'Add New Homeslider',
                    'edit_item' => 'Edit Homeslider',
                    'all_items' => 'All Homesliders',
                    'singular_name' => 'Homeslider'
            ),
            'menu_icon' => 'dashicons-format-image'
        ));


        //Event Post Type
        register_post_type('event', array(
            'supports' => array('title', 'editor', 'excerpt'),
            'rewrite' => array('slug' => 'events'),
            'has_archive' => true,
            'public' => true,
            'show_in_rest' => true,
            'labels' => array(
                    'name' => 'Events',
                    'add_new_item' => 'Add New Event',
                    'edit_item' => 'Edit Event',
                    'all_items' => 'All Events',
                    'singular_name' => 'Event'
            ),
            'menu_icon' => 'dashicons-calendar'
        ));

        //Pragram Post Type
        register_post_type('program', array(
            'supports' => array('title'),
            'rewrite' => array('slug' => 'programs'),
            'has_archive' => true,
            'public' => true,
            'show_in_rest' => true,
            'labels' => array(
                    'name' => 'Programs',
                    'add_new_item' => 'Add New Program',
                    'edit_item' => 'Edit Program',
                    'all_items' => 'All Programs',
                    'singular_name' => 'Program'
            ),
            'menu_icon' => 'dashicons-awards'
        ));

        //Professor Post Type
        register_post_type('professor', array(
                'has_archive' => true,
                'rewrite' => array('slug' => 'professors'),
                'supports' => array('title', 'editor', 'thumbnail'),
                'public' => true,
                'show_in_rest' => true,
                'labels' => array(
                    'name' => 'Professors',
                    'add_new_item' => 'Add New Professor',
                    'edit_item' => 'Edit Professor',
                    'all_items' => 'All Professors',
                    'singular_name' => 'Professor'
                ),
                'menu_icon' =>'dashicons-welcome-learn-more'
            ));

        //Campus Post Type
        register_post_type('campus', array(
            'supports' => array('title', 'editor', 'excerpt'),
            'rewrite' => array('slug' => 'campuses'),
            'has_archive' => true,
            'public' => true,
            'show_in_rest' => true,
            'labels' => array(
                    'name' => 'Campuses',
                    'add_new_item' => 'Add New Campus',
                    'edit_item' => 'Edit Campus',
                    'all_items' => 'All Campuses',
                    'singular_name' => 'Campus'
            ),
            'menu_icon' => 'dashicons-location-alt'
        ));


        //Notes Post Type
        register_post_type('note', array(
            'capability_type' =>'note',
            'map_meta_cap' => true,
            'supports' => array('title', 'editor'),
            'rewrite' => array('slug' => 'notes'),
            'public' => false,
            'show_ui' => true,
            'show_in_rest' => true,
            'labels' => array(
                    'name' => 'Notes',
                    'add_new_item' => 'Add New Note',
                    'edit_item' => 'Edit Note',
                    'all_items' => 'All Notes',
                    'singular_name' => 'Note'
            ),
            'menu_icon' => 'dashicons-welcome-write-blog'
        ));

        //Like Post Type
        register_post_type('like', array(
            'supports' => array('title'),
            'public' => false,
            'show_ui' => true,
            'labels' => array(
                    'name' => 'Likes',
                    'add_new_item' => 'Add New Like',
                    'edit_item' => 'Edit Like',
                    'all_items' => 'All Likes',
                    'singular_name' => 'Like'
            ),
            'menu_icon' => 'dashicons-heart'
        ));

    }
    add_action('init', 'university_post_types');




?>
