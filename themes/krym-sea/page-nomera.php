<?php get_header(); ?>

<main id="main-content" class="inner-page rooms-page">
    <div class="inner-page__container">

        <?php while (have_posts()) : the_post(); ?>

            <h1 class="inner-page__title">
                <?php the_title(); ?>
            </h1>

            <div class="inner-page__content">
                <?php the_content(); ?>
            </div>

            <?php
            $rooms = get_pages([
                'parent'      => get_the_ID(),
                'post_status' => 'publish',
                'sort_column' => 'menu_order,post_title',
            ]);
            ?>

            <?php if (!empty($rooms)) : ?>

                <div class="rooms-grid">

                    <?php foreach ($rooms as $room) : ?>

                        <article class="room-card">

                            <div class="room-card__media">
                                <?php if (has_post_thumbnail($room->ID)) : ?>

                                    <?php
                                    echo get_the_post_thumbnail(
                                        $room->ID,
                                        'medium_large',
                                        ['class' => 'room-card__image']
                                    );
                                    ?>

                                <?php else : ?>

                                    <div class="room-card__placeholder">
                                        Фотографии скоро появятся
                                    </div>

                                <?php endif; ?>
                            </div>

                            <div class="room-card__body">

                                <h2>
                                    <?php echo esc_html(
                                        get_the_title($room->ID)
                                    ); ?>
                                </h2>

                                <p>
                                    <?php echo esc_html(
                                        wp_trim_words(
                                            wp_strip_all_tags($room->post_content),
                                            22
                                        )
                                    ); ?>
                                </p>

                                <a
                                    class="room-card__link"
                                    href="<?php echo esc_url(
                                        get_permalink($room->ID)
                                    ); ?>"
                                >
                                    Подробнее о номере
                                </a>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>

            <?php else : ?>

                <p>Информация о категориях номеров подготавливается.</p>

            <?php endif; ?>

        <?php endwhile; ?>

    </div>
</main>

<?php get_footer(); ?>
