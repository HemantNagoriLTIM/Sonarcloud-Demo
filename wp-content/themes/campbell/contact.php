<?php 
/* Template Name: contact */
get_header(); ?>

    
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-4">
                    <div class="info">
                        <?php if(get_field('location_title') && get_field('location_address')){ ?>
                            <div class="address">
                                <i class="bi bi-geo-alt-fill"></i>
                                <h4><?php echo get_field('location_title'); ?></h4>
                                <p><?php echo get_field('location_address'); ?></p>
                            </div>
                        <?php } 
                        if(get_field('email_title') && get_field('email_id')){ ?>
                            <div class="email">
                                <i class="bi bi-envelope"></i>
                                <h4><?php echo get_field('email_title'); ?></h4>
                                <p><?php echo get_field('email_id'); ?></p>
                            </div>
                        <?php } 
                        if(get_field('phone_title') && get_field('phone_no')){
                        ?>
                            <div class="phone">
                                <i class="bi bi-phone"></i>
                                <h4><?php echo get_field('phone_title'); ?></h4>
                                <p><?php echo get_field('phone_no'); ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-lg-8 mt-5 mt-lg-0">
                    <?php
                    $featured_form = get_field('contact_form');
                    if( $featured_form ): 
                        echo do_shortcode('[contact-form-7 id="'.$featured_form->ID.'" title="Contact form 1"]'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->
    <?php
        while(have_posts()): the_post(); ?>
            <section class="container">
                <div class="row align-items-center rounded  mb-4 mt-4">
                    <div class="col-lg-12">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
    <?php
        endwhile;
    ?>       

<?php get_footer(); ?>