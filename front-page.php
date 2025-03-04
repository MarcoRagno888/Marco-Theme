<?php get_header(); ?>

<main class="front-wrapper">
    <?php wp_body_open(); ?>
    <h1>Front</h1>
    <div class="pages">
        <?php wp_link_pages(); ?>
    </div>
    <div>
        <?php posts_nav_link(); ?>
    </div>
    <div>
        <?php previous_posts_link(); ?>
    </div>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>