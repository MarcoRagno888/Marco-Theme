<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<?php get_header(); ?>
<?php get_sidebar(); ?>

<main class="front-wrapper">
    <?php wp_body_open(); ?>
    <h1>Pagina di atterraggio</h1>

    <div class="front-page-cards">
        <div class="front-page-card">
            <a href="/articoli"><h2>Articoli</h2></a>
        </div>
    </div>
</main>

<?php get_footer(); ?>