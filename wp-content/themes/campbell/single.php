<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();
?>
<!-- ======= Movie Details Section ======= -->
<section id="movie-details" class="movie-details">
  <div class="container">
    <div class="row gy-4 my-5">
      <div class="col-lg-12">
        <div class="movie-details">
          <div class="banner-wrapper-detail align-items-center">
            <div class="banner-slide-detail">
              <?php if(has_post_thumbnail()){ ?>
                <img src="<?php echo get_the_post_thumbnail_url($post->ID); ?>" alt="">
              <?php }else{ ?>
                <img src="<?php echo get_template_directory_uri(); ?>/images/no-image-icon.png';" alt="">
              <?php } ?>
            </div>
            <div class="movie-description">
              <p>
                <?php the_content(); ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section><!-- End Movie Details Section -->
<?php
endwhile; // End of the loop.
get_footer();
