<?php

if (!defined('ABSPATH')) {
    exit;
}

function krym_sea_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus([
        'primary' => 'Главное меню',
    ]);
}

add_action('after_setup_theme', 'krym_sea_setup');


function krym_sea_assets() {
    $version = wp_get_theme()->get('Version');

    wp_enqueue_style(
        'krym-sea-style',
        get_stylesheet_uri(),
        [],
        $version
    );

    wp_enqueue_style(
        'krym-sea-main',
        get_theme_file_uri('/assets/css/main.css'),
        ['krym-sea-style'],
        filemtime(get_theme_file_path('/assets/css/main.css'))
    );

    wp_enqueue_script(
        'krym-sea-main',
        get_theme_file_uri('/assets/js/main.js'),
        [],
        $version,
        [
            'in_footer' => true,
            'strategy' => 'defer'
        ]
    );
}

add_action('wp_enqueue_scripts', 'krym_sea_assets');


// Подключение версии для слабовидящих
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'krym-sea-accessibility',
        get_template_directory_uri() . '/assets/js/accessibility.js',
        array(),
        filemtime(
            get_template_directory() . '/assets/js/accessibility.js'
        ),
        true
    );
});


/* ========================================
   РЕДАКТИРУЕМОЕ ОБЪЯВЛЕНИЕ ПОД МЕНЮ
   Доступно администраторам и редакторам.
======================================== */

function krym_sea_notice_admin_menu() {
    add_menu_page(
        'Объявление под меню',
        'Объявление',
        'edit_pages',
        'krym-sea-notice',
        'krym_sea_notice_admin_page',
        'dashicons-megaphone',
        26
    );
}

add_action('admin_menu', 'krym_sea_notice_admin_menu');


function krym_sea_notice_admin_page() {
    if (!current_user_can('edit_pages')) {
        wp_die('У вас нет прав для изменения объявления.');
    }

    $enabled = (string) get_option(
        'krym_sea_notice_enabled',
        '0'
    );

    $message = (string) get_option(
        'krym_sea_notice_text',
        ''
    );
    ?>

    <div class="wrap">
        <h1>Объявление под главным меню</h1>

        <p>
            Здесь можно изменить надпись, которая
            отображается на всех страницах сайта
            сразу под верхним меню.
        </p>

        <?php if (
            isset($_GET['updated']) &&
            $_GET['updated'] === '1'
        ) : ?>
            <div class="notice notice-success is-dismissible">
                <p>Настройки объявления сохранены.</p>
            </div>
        <?php endif; ?>

        <form
            action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
            method="post"
        >
            <input
                type="hidden"
                name="action"
                value="krym_sea_save_notice"
            >

            <?php wp_nonce_field(
                'krym_sea_save_notice',
                'krym_sea_notice_nonce'
            ); ?>

            <table class="form-table" role="presentation">
                <tbody>

                    <tr>
                        <th scope="row">
                            Показ объявления
                        </th>

                        <td>
                            <label for="krym_sea_notice_enabled">
                                <input
                                    type="checkbox"
                                    id="krym_sea_notice_enabled"
                                    name="krym_sea_notice_enabled"
                                    value="1"
                                    <?php checked($enabled, '1'); ?>
                                >

                                Показывать строку под меню
                            </label>

                            <p class="description">
                                Если снять галочку, строка
                                полностью исчезнет со всех страниц.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="krym_sea_notice_text">
                                Текст объявления
                            </label>
                        </th>

                        <td>
                            <textarea
                                id="krym_sea_notice_text"
                                name="krym_sea_notice_text"
                                class="large-text"
                                rows="5"
                                maxlength="1000"
                                placeholder="Например: Внимание!"
                            ><?php echo esc_textarea($message); ?></textarea>

                            <p class="description">
                                Переносы строк сохраняются.
                                Можно написать заголовок на
                                отдельной строке и основной
                                текст ниже.
                            </p>

                            <p class="description">
                                Если поле пустое, объявление
                                не отображается даже при
                                установленной галочке.
                            </p>
                        </td>
                    </tr>

                </tbody>
            </table>

            <?php submit_button('Сохранить объявление'); ?>
        </form>
    </div>

    <?php
}


/* ========================================
   СОХРАНЕНИЕ ОБЪЯВЛЕНИЯ
   С СОХРАНЕНИЕМ ПЕРЕНОСОВ СТРОК
======================================== */

function krym_sea_notice_save() {
    if (!current_user_can('edit_pages')) {
        wp_die('У вас нет прав для изменения объявления.');
    }

    check_admin_referer(
        'krym_sea_save_notice',
        'krym_sea_notice_nonce'
    );

    // Включено или выключено объявление
    $enabled = isset($_POST['krym_sea_notice_enabled'])
        ? '1'
        : '0';

    // Получаем текст из формы
    $raw_text = (
        isset($_POST['krym_sea_notice_text']) &&
        is_string($_POST['krym_sea_notice_text'])
    )
        ? wp_unslash($_POST['krym_sea_notice_text'])
        : '';

    // Очищаем текст, сохраняя переносы строк
    $message = sanitize_textarea_field($raw_text);

    // Нормализуем переносы строк
    $message = str_replace(
        ["\r\n", "\r"],
        "\n",
        $message
    );

    // Ограничиваем текст 1000 символами.
    // mb_substr НЕ удаляет переносы строк.
    $message = mb_substr(
        $message,
        0,
        1000,
        'UTF-8'
    );

    // Сохраняем настройки в базе WordPress
    update_option(
        'krym_sea_notice_enabled',
        $enabled
    );

    update_option(
        'krym_sea_notice_text',
        $message
    );

    // Возвращаемся в админку
    wp_safe_redirect(
        admin_url(
            'admin.php?page=krym-sea-notice&updated=1'
        )
    );

    exit;
}

add_action(
    'admin_post_krym_sea_save_notice',
    'krym_sea_notice_save'
);
