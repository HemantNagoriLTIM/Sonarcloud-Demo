<?php

/* add html5 support */
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );

/* add title tag support */
add_theme_support( 'title-tag' );

/* add menu support */
add_theme_support( 'menus' );

/* add custom thumbnail support */
add_theme_support( 'post-thumbnails' );
add_filter('https_ssl_verify', '__return_false');
/* add custom logo support */
add_theme_support( 'custom-logo', array(
    'height'               => 100,
    'width'                => 400,
    'flex-height'          => true,
    'flex-width'           => true,
    'header-text'          => array( 'site-title', 'site-description' ),
    'unlink-homepage-logo' => true,
) );

// bootstrap 5 wp_nav_menu walker
class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu
{
  private $current_item;
  private $dropdown_menu_alignment_values = [
    'dropdown-menu-start',
    'dropdown-menu-end',
    'dropdown-menu-sm-start',
    'dropdown-menu-sm-end',
    'dropdown-menu-md-start',
    'dropdown-menu-md-end',
    'dropdown-menu-lg-start',
    'dropdown-menu-lg-end',
    'dropdown-menu-xl-start',
    'dropdown-menu-xl-end',
    'dropdown-menu-xxl-start',
    'dropdown-menu-xxl-end'
  ];

  function start_lvl(&$output, $depth = 0, $args = null)
  {
    $dropdown_menu_class[] = '';
    foreach($this->current_item->classes as $class) {
      if(in_array($class, $this->dropdown_menu_alignment_values)) {
        $dropdown_menu_class[] = $class;
      }
    }
    $indent = str_repeat("\t", $depth);
    $submenu = ($depth > 0) ? ' sub-menu' : '';
    $output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    $this->current_item = $item;

    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $li_attributes = '';
    $class_names = $value = '';

    $classes = empty($item->classes) ? array() : (array) $item->classes;

    $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
    $classes[] = 'nav-item';
    $classes[] = 'nav-item-' . $item->ID;
    if ($depth && $args->walker->has_children) {
      $classes[] = 'dropdown-menu dropdown-menu-end';
    }

    $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
    $class_names = ' class="' . esc_attr($class_names) . '"';

    $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
    $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

    $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

    $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

    $active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
    $nav_link_class = ( $depth > 0 ) ? 'dropdown-item ' : 'nav-link ';
    $attributes .= ( $args->walker->has_children ) ? ' class="'. $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="'. $nav_link_class . $active_class . '"';

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}

// register a new menu
register_nav_menu('main-menu', 'Main menu');

/* Function to display logo in header */ 
function site_logo(){
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );

    if ( has_custom_logo() ) {
    echo '<a href="'.get_home_url().'" ><img class="custom-logo" src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '"></a>';
    } else {
    echo '<a href="'.get_home_url().'" ><h3>' . get_bloginfo('name') . '</h3></a>';
    }
}

/* load styles and scripts */
function tp_scripts() {
    
    wp_enqueue_style( 'default', get_theme_file_uri('/style.css') );
    
    wp_enqueue_style( 'bootstrap-min', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' );
    wp_enqueue_style( 'bootstrap-icon', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css' );
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css' );
    wp_enqueue_script( 'bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.js', array(), '1.0.0', true );
    wp_enqueue_script( 'jquery-min', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js' );
    wp_enqueue_script( 'jquery-local', get_template_directory_uri() . '/assets/js/jquery.js', array(), '1.0.0', false );
    wp_enqueue_script( 'bootstrap-min', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js' );
    
    
}
add_action( 'wp_enqueue_scripts', 'tp_scripts' );

/* custom excerpt length */
function tp_custom_excerpt_length( $length ) {
return 20;
}
add_filter( 'excerpt_length', 'tp_custom_excerpt_length', 999 );

/* Custom Excerpt read more text */
function tp_custom_excerpt_more($more) {
    global $post;
    return ' ...';
}
add_filter('excerpt_more', 'tp_custom_excerpt_more');

function create_post_type(  string $singular = 'Customer', 
                            string $plural = 'Customers', 
                            string $menu_icon = 'dashicons-carrot',
                            bool $hierarchical = FALSE, 
                            bool $has_archive = TRUE, 
                            string $description = '' ) {
        //Here, the default post type if no argument is passed to create_post_type() will be Customer CPT

        register_post_type( $singular, array(
        'public'            => TRUE,
        'show_in_rest'      => TRUE,
        'description'       => $description,
        'menu_icon'         => $menu_icon,
        'hierarchical'      => $hierarchical,
        'has_archive'       => $has_archive,
        'supports'          => array('title', 'editor', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields', 'comments'),
        'labels' => array(
            'name'                      => _x( $plural, 'post type general name', 'campbell' ),
            'singular_name'             => _x( $singular, 'post type singular name', 'campbell' ),
            'add_new'                   => __( 'Add New '.$singular, 'campbell' ),
            'add_new_item'              => __( 'New '.$singular, 'campbell' ),
            'edit_item'                 => __( 'Edit '.$singular, 'campbell' ),
            'view_item'                 => __( 'View '.$singular, 'campbell' ),
            'view_items'                => __( 'View '.$plural, 'campbell' ),
            'search_items'              => __( 'Search '.$plural, 'campbell' ),
            'not_found'                 => __( 'No '.$plural.' Found', 'campbell' ),
            'all_items'                 => __( 'All '.$plural, 'campbell' ),
            'archives'                  => __( $plural.' Archives', 'campbell' ),
            'attributes'                => __( $singular.' Attributes', 'campbell' ),
            'insert_into_item'          => __( 'Insert into '.$singular, 'campbell' ),
            'uploaded_to_this_item'     => __( 'Uploaded to this '.$singular, 'campbell' ),
            'featured_image'            => __( $singular.' Featured image', 'campbell' ),
            'set_featured_image'        => __( 'Set '.$singular.' featured image', 'campbell' ),
            'remove_featured_image'     => __( 'Remove '.$singular.' featured image', 'campbell' ),
            'use_featured_image'        => __( 'Use as '.$singular.' featured image', 'campbell' ),
            'filter_items_list'         => __( 'Filter '.$plural.' list', 'campbell' ),
            'filter_by_date'            => __( 'Filter '.$plural.' by date', 'campbell' ),
            'items_list_navigation'     => __( $plural.' list navigation', 'campbell' ),
            'items_list'                => __( $plural.' list', 'campbell' ),
            'item_published'            => __( $singular.' published.', 'campbell' ),
            'item_published_privately'  => __( $singular.' published privately.', 'campbell' ),
            'item_reverted_to_draft'    => __( $singular.' reverted to draft.', 'campbell' ),
            'item_scheduled'            => __( $singular.' scheduled.', 'campbell' ),
            'item_updated'              => __( $singular.' updated.', 'campbell' ),
            'item_link'                 => __( $singular.' link', 'campbell' ),
        ),

        'rewrite'           => array(
        'slug'              => strtolower($plural),
        'pages'             => TRUE,
        )
    ));
    
}
function custom_cpts() {
    create_post_type('Movie', 'Movies','dashicons-format-video');
    create_post_type('News', 'News', 'dashicons-book');
    
}

add_action( 'init', 'custom_cpts' );

    // Register Custom Taxonomy
function custom_taxonomy() {

    $taxonomies = array(
		array(
			'slug'         => 'movie-type',
			'single_name'  => 'Movie Type',
			'plural_name'  => 'Movie Types',
			'post_type'    => 'movie',
			'rewrite'      => array( 'slug' => 'movie-type' ),
		),
		array(
			'slug'         => 'news-type',
			'single_name'  => 'News Type',
			'plural_name'  => 'News Types',
			'post_type'    => 'news',
			'hierarchical' => false,
		),
		array(
			'slug'         => 'job-experience',
			'single_name'  => 'Min-Experience',
			'plural_name'  => 'Min-Experiences',
			'post_type'    => 'jobs',
		),
	);

	foreach( $taxonomies as $taxonomy ) {
		$labels = array(
			'name' => $taxonomy['plural_name'],
			'singular_name' => $taxonomy['single_name'],
			'search_items' =>  'Search ' . $taxonomy['plural_name'],
			'all_items' => 'All ' . $taxonomy['plural_name'],
			'parent_item' => 'Parent ' . $taxonomy['single_name'],
			'parent_item_colon' => 'Parent ' . $taxonomy['single_name'] . ':',
			'edit_item' => 'Edit ' . $taxonomy['single_name'],
			'update_item' => 'Update ' . $taxonomy['single_name'],
			'add_new_item' => 'Add New ' . $taxonomy['single_name'],
			'new_item_name' => 'New ' . $taxonomy['single_name'] . ' Name',
			'menu_name' => $taxonomy['plural_name']
		);
		
	
		register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
			'labels' => $labels,
			'query_var' => true,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui' => true,
            'has_archive'=> true,
            'show_in_rest'=> true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'meta_box_cb' => true,
		));
	}

}
add_action( 'init', 'custom_taxonomy', 0 );
remove_filter ('acf_the_content', 'wpautop');

function import_movies() {
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://moviesdatabase.p.rapidapi.com/titles/x/upcoming?limit=5",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: moviesdatabase.p.rapidapi.com",
            "X-RapidAPI-Key: a50d7b0883mshaa304b78add813fp1a8567jsn9ea9a5f43be3"
        ],
    ]);

    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    $final_res= json_decode( $response, true);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        // echo "<pre>";
        // print_r($final_res);
        // echo "</pre>";
        // exit;
        foreach($final_res['results'] as $movie){
            $movie_title = $movie['originalTitleText']['text'];
            $movie_content = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.';
            $movie_banner = $movie['primaryImage']['url'];
            $movie_release_date = $movie['releaseDate']['day'].'-'.$movie['releaseDate']['month'].'-'.$movie['releaseDate']['year'];
            $post_check = post_exists( $movie_title,'', '','','publish' );
            $movie_type = 'hollywood';
            if ( 0 === $post_check ) {
                $post_id = wp_insert_post(array (
                    'post_type' => 'movie',
                    'post_title' => $movie_title,
                    'post_content' => $movie_content,
                    'post_status' => 'publish',
                    'comment_status' => 'closed',   // if you prefer
                    'ping_status' => 'closed',      // if you prefer
                 ));
                 wp_set_object_terms( $post_id, $movie_type, 'movie-type' );
                 update_field('release_date', $movie_release_date, $post_id);
                 if($movie_banner){
                    $image = media_sideload_image( $movie_banner, $post_id );
                    set_post_thumbnail( $post_id, $image );
                 }
            }elseif($post_check != 0){
                $data = array(
                'ID' => $post_check,
                'post_content' => $movie_content,
                );
                
                $post_id = wp_update_post( $data );
                wp_set_object_terms( $post_id, $movie_type, 'movie-type' );
                update_field('release_date', $movie_release_date, $post_check);
                if($movie_banner){
                $image = media_sideload_image( $movie_banner, $post_check, '', 'id' );
                // echo 'attach '.get_attachment_id_from_src($image);
                set_post_thumbnail( $post_check, $image );
                }
            }
            echo $post_id.' movie id inserted or updated.<br>';
             
            
        }

    }
    die;
}
add_action( 'wp_ajax_import_movies', 'import_movies' );    // If called from admin panel
add_action( 'wp_ajax_nopriv_import_movies', 'import_movies' );    // If called from front end
