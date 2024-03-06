<?php  
/* Template Name: Movie */
get_header();
?>
<section id="listing">
    <?php
    $args = array(
        'post_type'=> 'movie',
        'orderby'    => 'ID',
        'post_status' => 'publish',
        'order'    => 'DESC',
        'posts_per_page' => -1 // this will retrive all the post that is published 
        );
        $result = new WP_Query( $args );
        if ( $result-> have_posts() ) : ?>

    <div class="container bootstrap snippets bootdey">
        <div class="row my-5">
        <?php while ( $result->have_posts() ) : $result->the_post(); ?>
            <div class="post-list">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="picture">
                            <?php if(has_post_thumbnail()){ ?>
                                <img src="<?php echo get_the_post_thumbnail_url($post->ID); ?>" alt="">
                            <?php }else{ ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/no-image-icon.png';" alt="">
                            <?php } ?>
                            
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h4>
                            <a hre="#" class="username"><?php echo get_the_title(); ?></a>
                        </h4>
                        <h5> 
                        <i class="fa fa-calendar"></i>
                        <?php echo get_field('release_date'); ?>
                        </h5>
                        <p class="description"><?php echo get_the_excerpt(); ?></p>    
                    </div>
                    <div class="col-sm-4" data-no-turbolink="">
                        <a class="btn btn-info btn-download btn-round pull-right makeLoading" href="<?php echo get_the_permalink(); ?>">
                        <i class="fa fa-share"></i> View Details
                        </a>            
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php endif; wp_reset_postdata(); ?> 
        </div>
    </div>
</section>
<?php get_footer(); ?>