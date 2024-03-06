<?php  
/* Template Name: News */
get_header();
?>
<section id="listing">
    <?php
    $args = array(
        'post_type'=> 'news',
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
            <div class="card card-body mb-3" style="width: 18rem;">
                <?php if(has_post_thumbnail()){ ?>
                    <img class="card-img-top" src="<?php echo get_the_post_thumbnail_url($post->ID); ?>" alt="">
                <?php }else{ ?>
                    <img class="card-img-top" src="<?php echo get_template_directory_uri(); ?>/assets/images/no-image-icon.png';" alt="">
                <?php } ?>
                <div class="card-body">
                    <a href="<?php echo get_the_permalink(); ?>" target="_blank"><h5 class="card-title"><?php echo get_the_title(); ?></h5></a>
                    <p class="card-text"><?php echo get_the_excerpt(); ?></p>
                    <a href="<?php echo get_the_permalink(); ?>" class="btn btn-info btn-primary" target="_blank">Read More</a>
                </div>
            </div>
            <?php endwhile; ?>
            <?php endif; wp_reset_postdata(); ?> 
        </div>
    </div>
</section>
<?php get_footer(); ?>