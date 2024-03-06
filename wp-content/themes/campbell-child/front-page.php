<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <?php
            while(have_posts()): the_post();
                the_content();
            endwhile;
            ?>
            <section class="pt-5 pb-5">
                <div class="container">
                    <div class="row">
                        <h2>Latest Movies</h2>
                        <div id="myCarousel" class="carousel slide container" data-bs-ride="carousel">
                            <div class="carousel-inner w-100 mt-5">
                                <?php
                                // Item size (set here the number of posts for each group)
                                $i = 4; 
                                // Set the arguments for the query
                                global $post; 
                                $args = array( 
                                'numberposts'   => -1, // -1 is for all
                                'post_type'     => 'movie', // or 'post', 'page'
                                'orderby'       => 'title', // or 'date', 'rand'
                                'order' 	      => 'ASC', // or 'DESC'
                                );

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
                                echo $html;

                                endif;
                                ?>  
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
            <section class="pb-5">
                <div class="container">
                    <div class="row">
                        <h2>Latest Hollywood Movies</h2>
                        <div id="myCarousel-hollywood" class="carousel slide container" data-bs-ride="carousel">
                            <div class="carousel-inner w-100 mt-5">
                                <?php echo do_shortcode('[hollywood_movies num="5" order="asc"]'); ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel-hollywood" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel-hollywood" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="pb-5">
                <div class="container">
                    <div class="row">
                        <h2>Latest News</h2>
                        <div id="myCarousel-child" class="carousel slide container" data-bs-ride="carousel">
                            <div class="carousel-inner w-100 mt-5">
                                <?php echo do_shortcode('[recent_news num="5" order="asc"]'); ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel-child" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel-child" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php get_footer(); ?>