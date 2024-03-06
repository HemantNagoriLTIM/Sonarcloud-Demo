<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@600&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <div class="container-fluid">
            <?php site_logo(); ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="main-menu">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'main-menu',
                        'menu_class' => 'navbar-nav',
                        'fallback_cb' => '__return_false',
                        'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
                        'container_class'=> 'ms-auto ', 
                        'menu_class'=>'navbar-nav',
                        'walker' => new bootstrap_5_wp_nav_menu_walker()
                    ));
                    ?>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Hero Banner Section -->
    <section id="hero" class="hero d-flex align-items-center justify-content-center py-5" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/White-Chicken-Chili_homepage-hero-1536x576.jpg'); height:100%; width:100%;">
        <div class="container" data-aos="fade-up">

        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 text-center bg-white bg-opacity-75 text-dark px-5">
                <?php if(get_field('banner_title')){ ?>
                    <h1 class="my-3 "><?php echo get_field('banner_title'); ?></h1>
                <?php }else{ ?>
                    <h1 class="my-3 "><?php the_title(); ?></h1>
                <?php } 
                if(get_field('banner_sub_title')){ ?>
                    <p class="lead my-4"><?php echo get_field('banner_sub_title',false,false); ?></p>
                <?php } 
                $link = get_field('banner_cta');
                if( $link ): 
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="btn btn-primary btn-lg border mb-3"><?php echo esc_html( $link_title ); ?></a>
                <?php endif; ?>
            </div>
        </div>
        </div>
    </section><!-- End Hero -->
    <main>