<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<main style="padding: 60px 24px;">
    <h1><?php echo esc_html(get_bloginfo('name')); ?></h1>
    <p>Наша морская тема WordPress работает!</p>
</main>

<?php wp_footer(); ?>

</body>
</html>