<?php
    require get_theme_file_path('/inc/search-route.php');
    require get_theme_file_path('/inc/like-route.php');

    //custom REST fields
function university_custom_rest() {
        register_rest_field('post', 'authorName', array(
            'get_callback' => function () {return get_the_author();}
        ));

        register_rest_field('note', 'userNoteCount', array(
            'get_callback' => function () {return count_user_posts(get_current_user_id(), 'note');}
        ));
    }
    add_action('rest_api_init', 'university_custom_rest');
    

function PageBanner($args = NULL){
        //php logic for generating banner details
        if(!isset($args['title'])){
            $args['title'] = get_the_title();
        }

        if(!isset($args['subtitle'])){
            $args['subtitle'] = get_field('page_banner_subtitle');
        }

        if(!isset($args['img'])){
            $pageBannerImage = get_field('page_banner_background_image');
            if($pageBannerImage){
                $args['img'] = $pageBannerImage['sizes']['pageBanner'];
            } else{
                $args['img'] = get_theme_file_uri('images/ocean.jpg');;
            }
        }

        ?>
        <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['img'];?>);"></div>
        
        <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title'];?></h1>
        <div class="page-banner__intro">
            <p><?php echo $args['subtitle'];?></p>
        </div>
        </div>  
    </div>
    <?php
    }
    
function univerity_files(){
       // wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
       // wp_enqueue_style('university_main_styles', get_stylesheet_uri());
        wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
        wp_enqueue_style('custom-google-fonts','//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

        wp_localize_script('main-university-js', 'universityData', array(
                    'root_url' => get_site_url(),
                    'nonce' => wp_create_nonce('wp_rest')
        ));
    }
    add_action('wp_enqueue_scripts','univerity_files');


function university_features(){
        register_nav_menu('headerMenuLocation', 'Header Menu Location');
        register_nav_menu('footerLocation1', 'Footer Location 1');
        register_nav_menu('footerLocation2', 'Footer Location 2');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_image_size('professorLandscape', 400, 260, true);
        add_image_size('professorPortrait', 480, 650, true);
        add_image_size('pageBanner', 1500, 350, true);
        add_image_size('slideshowImage', 1900, 525, true);
    }
    add_action('after_setup_theme', 'university_features');

    
function university_adjust_queries($query){
        if(!is_admin() && is_post_type_archive('event') && $query->is_main_query()){
            $today = date('Ymd');
            $query->set('meta_key', 'event_date');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'ASC');
            $query->set('meta_query', array(
                    array(
                        'key' => 'event_date',
                        'compare' => '>=',
                        'value' => $today,
                        'type' => 'numeric'
                    )
                    ));
        }

        if(!is_admin() && is_post_type_archive('program') && $query->is_main_query()){
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');
            $query->set('posts_per_page', -1);
        }

        if(!is_admin() && is_post_type_archive('campus') && $query->is_main_query()){
          $query->set('posts_per_page', -1);
        }

    }
    add_action('pre_get_posts', 'university_adjust_queries');


    //ADDING AN ACTIVE CLASS TO THE CUSTOM POST-TYPE MENU ITEM WHEN VISITING ITS SINGLE POST PAGES
function custom_active_item_classes($classes = array(), $menu_item = false){            
        global $post;
        if(have_posts()){
            $classes[] = ($menu_item->url == get_post_type_archive_link($post->post_type)) ? 'current-menu-item active' : '';
        } else {
            $classes[] = "";
        }
        return $classes;
        }
        add_filter( 'nav_menu_css_class', 'custom_active_item_classes', 10, 2 );


//Redirect Subscriber out of admin and onto homeapage
function redirectSubsToFrontend() {
        $ourCurrentUser = wp_get_current_user();
        if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0]=='subscriber'){
            wp_redirect(site_url('/'));
            exit;
        } 
    }
    add_action('admin_init', 'redirectSubsToFrontend');

function noSubsAdminBar() {
        $ourCurrentUser = wp_get_current_user();
        if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0]=='subscriber'){
            show_admin_bar(false);
            } 
    }
    add_action('wp_loaded', 'noSubsAdminBar');

//Customize Login Screen
function ourHeaderUrl() {
    return esc_url(site_url('/'));
    }
    add_filter('login_headerurl', 'ourHeaderUrl');

function ourLoginCSS() {
        wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
        wp_enqueue_style('custom-google-fonts','//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    }
    add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginTitle() {
        return get_bloginfo('name');
    }
    add_filter('login_headertitle', 'ourLoginTitle');

#Force note posts to be private
function makeNotePrivate($data, $postarr) {
    if($data['post_type'] == 'note'){
        if(count_user_posts(get_current_user_id(), 'note') > 4 AND !$postarr['ID']){
            die("You have reached your note limit");
        }
        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);
    }

    if($data['post_type'] == 'note' AND $data['post_status'] != 'trash'){
        $data['post_status'] = "private";
    }
        return $data;
    }
    add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);


function ignoreCertainFiles($exclude_filters) {
        $exclude_filters[] = "themes/fictional-univ-theme/node_modules";  
        return $exclude_filters;
    }
    add_filter('ai1wm_exclude_content_from_export', 'ignoreCertainFiles');


?>
