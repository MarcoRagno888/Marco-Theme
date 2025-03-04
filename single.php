<?php get_header(); ?>

<main class="single-post-page-wrapper">
    <section class="single-post-container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <article>
                    <header>
                        <h2><?php the_title(); ?></h2>
                        <?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
                    </header>
                    <?php the_content(); ?>
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
    </section>
</main>

<?php get_footer(); ?>