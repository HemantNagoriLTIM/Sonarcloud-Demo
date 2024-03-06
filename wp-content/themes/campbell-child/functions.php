<?php
/* load styles and scripts */
function tp_child_scripts() {

    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );   
    
}
add_action( 'wp_enqueue_scripts', 'tp_child_scripts' );

function latest_news($atts, $content = null) {
	
	global $post;
	$i=4;
	extract(shortcode_atts(array(
		'num'     => '5',
		'order'   => 'DESC',
		'orderby' => 'post_date',
	), $atts));
	
	$args = array(
        'post_type'     => 'news',
		'posts_per_page' => $num,
		'order'          => $order,
		'orderby'        => $orderby,
	);
	
	$html = '';
	
	// Get the posts
    $myposts = get_posts($args);

    // If there are posts
    if($myposts):

    // Groups the posts in groups of $i
    $chunks = array_chunk($myposts, $i);
    $html = "";
    /*
    * Item
    * For each group (chunk) it generates an item
    */
    foreach($chunks as $chunk):
        // Sets as 'active' the first item
        ($chunk === reset($chunks)) ? $active = "active" : $active = "";
        $html .= '<div class="carousel-item '.$active.'">';

        /*
        * Posts inside the current Item
        * For each item it generates the posts HTML
        */
        foreach($chunk as $post):
            
            $main_img = '';
            $main_img = get_the_post_thumbnail_url($post->ID);
            if($main_img == ''){
                $main_img = get_template_directory_uri().'/assets/images/no-image-icon.png';
            }
        $html .= '<div class="col-md-3 d-flex">
                        <div class="card card-body mb-3">
                            <img class="img-fluid card-img-top" src="'.$main_img.'">
                            <div class="card-body">
                                <a href='.get_the_permalink($post->ID).' target="_blank"><h5 class="card-title">'.get_the_title($post->ID).'</h5></a>
                                <p class="card-text">'.get_the_excerpt().'</p>
                            </div>
                        </div>
                    </div>';
        
        endforeach;

        $html .= '</div>';	

    endforeach;

    // Prints the HTML
    return $html;

    endif;
}
add_shortcode('recent_news', 'latest_news');

function movies_hollywood($atts, $content = null) {
	global $wpdb;
    $i = 4;
    $post_type_query = " AND post_type = 'movie'";
    $hollywood_post = $wpdb->get_results(
        "SELECT *
                    FROM {$wpdb->posts} AS wposts
                    LEFT JOIN {$wpdb->postmeta} AS wpostmeta ON (wposts.ID = wpostmeta.post_id)
                    LEFT JOIN {$wpdb->term_relationships} AS tax_rel ON (wposts.ID = tax_rel.object_id)
                    LEFT JOIN {$wpdb->term_taxonomy} AS term_tax ON (tax_rel.term_taxonomy_id = term_tax.term_taxonomy_id)
                    LEFT JOIN {$wpdb->terms} AS terms ON (terms.term_id = term_tax.term_id)
            WHERE post_status = 'publish'" . $post_type_query .
        "AND terms.name = 'hollywood'
            AND term_tax.taxonomy = 'movie-type'",
        OBJECT_K
    );
    
    // If there are posts
    if($hollywood_post):

    // Groups the posts in groups of $i
    $chunks = array_chunk($hollywood_post, $i);
    $html = "";
    /*
    * Item
    * For each group (chunk) it generates an item
    */
    foreach($chunks as $chunk):
        // Sets as 'active' the first item
        ($chunk === reset($chunks)) ? $active = "active" : $active = "";
        $html .= '<div class="carousel-item '.$active.'">';

        /*
        * Posts inside the current Item
        * For each item it generates the posts HTML
        */
        foreach($chunk as $post):
            
            $main_img = '';
            $main_img = get_the_post_thumbnail_url($post->ID);
            if($main_img == ''){
                $main_img = get_template_directory_uri().'/assets/images/no-image-icon.png';
            }
        $html .= '<div class="col-md-3 d-flex">
                        <div class="card card-body mb-3">
                            <img class="img-fluid card-img-top" src="'.$main_img.'">
                            <div class="card-body">
                                <a href='.get_the_permalink($post->ID).' target="_blank"><h5 class="card-title">'.get_the_title($post->ID).'</h5></a>
                                <p class="card-text">'.get_the_excerpt().'</p>
                            </div>
                        </div>
                    </div>';
        
        endforeach;

        $html .= '</div>';	

    endforeach;

    // Prints the HTML
    return $html;

    endif;
}
add_shortcode('hollywood_movies', 'movies_hollywood');