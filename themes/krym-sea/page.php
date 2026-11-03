<?php get_header(); ?>

<main id="main-content" class="inner-page">
    <div class="inner-page__container">

        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>

                <article <?php post_class('content-page'); ?>>

                    <h1 class="inner-page__title">
                        <?php the_title(); ?>
                    </h1>

                    <div class="inner-page__content">
                        <?php the_content(); ?>
                    </div>

                </article>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
