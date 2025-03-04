<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<?php get_header(); ?>
<?php get_sidebar(); ?>

<body <?php body_class(); ?> class="page-articoli-wrapper">

    <div class="page-articoli-main-section">
        <div class="page-articoli-title">
            <h1>Articoli</h1>
        </div>

        <div class="page-articoli-cards">
            <?php  
                $args = array(
                    'order' => 'ASC',
                    'posts_per_page' => 10,
                );
                
                $posts = new WP_Query( $args );
            ?>
            <?php while ($posts->have_posts()) : $posts->the_post(); ?>
                <div class="page-articoli-card">
                    <a href="<?php echo get_permalink() ?>">
                        <?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ); ?>
                        <img src="<?php echo $url ?>" width="200" height="100" />

                        <div class="page-articoli-card-body">
                            <h2><?php echo the_title(); ?></h2>
                    </a>
                            <p><?php echo the_excerpt() ?></p>
                        </div>
                </div>
            <?php endwhile; wp_reset_postdata();?>
        </div>

    </div>
    
    <div class="actions">
        <div class="action-pages">
            <a href="/"><button type="button" class="btn btn-primary">1</button></a>
            <a href="/"><button type="button" class="btn btn-primary">2</button></a>
        </div>
        <div class="action-next">
            <a href="/"><button type="button" class="btn btn-light">Successiva -></button></a>
        </div>
    </div>
</body>

<?php get_footer(); ?>