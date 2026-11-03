<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content">
    Перейти к содержимому
</a>

<header class="site-header" id="top">
    <div class="header-inner">

        <a
            class="brand"
            href="<?php echo esc_url(home_url('/')); ?>"
        >
            <span class="brand__emblem" aria-hidden="true">
                <img
                    src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/placeholder.svg'); ?>"
                    alt=""
                    width="300"
                    height="194"
                    decoding="async"
                >
            </span>

            <span class="brand__text">
                <span class="brand__title">
                    Военный санаторий «Крым»
                </span>

                <span class="brand__subtitle">
                    Министерство обороны России
                </span>
            </span>
        </a>

        <button
            class="burger"
            id="burger"
            type="button"
            aria-label="Открыть меню"
            aria-controls="main-menu"
            aria-expanded="false"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav
            class="main-nav"
            id="main-menu"
            aria-label="Основная навигация"
        >
            <a href="<?php echo esc_url(home_url('/o-sanatorii/')); ?>">
                О санатории
            </a>

            <a href="<?php echo esc_url(home_url('/lechenie/')); ?>">
                Лечение
            </a>

            <a href="<?php echo esc_url(home_url('/nomera/')); ?>">
                Номерной фонд
            </a>

            <a href="<?php echo esc_url(home_url('/ceny/')); ?>">
                Цены
            </a>

            <a href="<?php echo esc_url(home_url('/putevki-2/')); ?>">
                Путевки
            </a>

            <a href="<?php echo esc_url(home_url('/uslugi/')); ?>">
                Услуги
            </a>

            <a href="<?php echo esc_url(home_url('/informaciya/')); ?>">
                Информация
            </a>

            <a href="<?php echo esc_url(home_url('/kontakty/')); ?>">
                Контакты
            </a>
        </nav>

        <a
            class="header-button"
            href="<?php echo esc_url(home_url('/kontakty/')); ?>"
            target="_blank"
            rel="noopener noreferrer"
        >
            Контакты демо
        </a>

    </div>
</header>

<?php
// Полоса отображается только при включённом показе и непустом тексте.
$krym_sea_notice_enabled = get_option('krym_sea_notice_enabled', '0') === '1';
$krym_sea_notice_text = trim((string) get_option('krym_sea_notice_text', ''));
if ($krym_sea_notice_enabled && $krym_sea_notice_text !== '') :
?>
    <div class="site-notice" role="note" aria-label="Объявление санатория">
        <div class="site-notice__inner"><?php echo esc_html($krym_sea_notice_text); ?></div>
    </div>
<?php endif; ?>
