<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<?php get_header(); ?>
<?php get_sidebar(); ?>

<main class="single-post-page-wrapper">

    <section class="single-post-container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <article>
                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
                    <?php the_content(); ?>
                    <?php the_tags() ?>
                </article>
            </div>
        <?php endwhile; else : ?>
            <article>
                <p>Sorry, no post was found!</p>
            </article>
        <?php endif; ?>
        <div class="comments">
            <?php if ( comments_open() || get_comments_number() ) : ?>
                <?php comments_template(); ?>

                <div class="comment-list">
                    <?php 
                        wp_list_comments( array(
                            'style'      => 'ul',
                            'short_ping' => true,
                            'avatar_size' => 50,
                        ) ); 
                    ?>
                </div>

                <div class="comment-pagination">
                    <?php paginate_comments_links(); ?>
                </div>

                <?php comment_form(); ?>
            <?php endif; ?>
        </div>
        <div class="pagination">
            <?php
            previous_posts_link( __( '&laquo; Previous', 'marco-theme' ) );
            next_posts_link( __( 'Next &raquo;', 'marco-theme' ) );
            wp_link_pages();
            ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>