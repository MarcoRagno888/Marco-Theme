<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
   <meta charset="<?php bloginfo( 'charset' ); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
   <?php wp_head(); ?>
 </head>

<header>
    <nav id="site-navigation" class="main-navigation">
        <a href="/"><img src="<?php echo get_template_directory_uri(); ?>/screenshot.png" alt="Logo" width="50" height="50">
        <h4>Marco Theme</h4></a>
        <?php wp_nav_menu( array( 'theme_location' => 'marco-theme' )); ?>
    </nav>
</header>
