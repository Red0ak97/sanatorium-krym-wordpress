<?php
// Подключаем слайд-шоу только на главной странице, не затрагивая main.js и accessibility.js.
$about_slider_file = get_template_directory() . '/assets/js/about-slider.js';
if (file_exists($about_slider_file)) {
    wp_enqueue_script(
        'krym-sea-about-slider',
        get_template_directory_uri() . '/assets/js/about-slider.js',
        array(),
        (string) filemtime($about_slider_file),
        true
    );
}
get_header();
?>

<main id="main-content">

    <!-- ГЛАВНЫЙ ЭКРАН -->
    <section class="hero">
        <div class="hero__image"></div>

        <div class="hero__content">
            <span class="hero__label">
                Южный берег Крыма · Партенит
            </span>

            <h1>
                Военный санаторий<br>
                «Крым»
            </h1>

            <p class="hero__description">
                Оздоровление, лечение и отдых на территории
                уникального парка у подножия Аю-Дага.
                Комфортный климат, море и медицинская реабилитация.
            </p>

            <div class="hero__actions">
                <a
                    href="<?php echo esc_url(home_url('/kontakty/')); ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="button button--accent"
                >
                    Демонстрационные контакты
                </a>

                <a href="#treatment" class="button button--outline">
                    Узнать о лечении
                </a>
            </div>
        </div>
    </section>


    <!-- САНАТОРИЙ В ЦИФРАХ -->
    <section class="stats" aria-label="О санатории в цифрах">
        <div class="stats__grid">

            <div class="stat">
                <span class="stat__number">40 га</span>
                <span class="stat__label">
                    Территория парка
                </span>
            </div>

            <div class="stat">
                <span class="stat__number">160+</span>
                <span class="stat__label">
                    Видов растений
                </span>
            </div>

            <div class="stat">
                <span class="stat__number">8</span>
                <span class="stat__label">
                    Лечебных зон
                </span>
            </div>

            <div class="stat">
                <span class="stat__number">1974</span>
                <span class="stat__label">
                    Год открытия санатория «Крым»
                </span>
            </div>

        </div>
    </section>


    <!-- О САНАТОРИИ -->
    <section
        class="about-section"
        id="about"
        aria-labelledby="about-title"
    >
        <div class="about-container">

            <div class="about-visual" aria-label="Фотографии территории санатория Крым">
                <div class="about-visual__slides" aria-hidden="true">
                    <span class="about-visual__slide about-visual__slide--1 is-active"></span>
                    <span class="about-visual__slide about-visual__slide--2"></span>
                    <span class="about-visual__slide about-visual__slide--3"></span>
                    <span class="about-visual__slide about-visual__slide--4"></span>
                    <span class="about-visual__slide about-visual__slide--5"></span>
                    <span class="about-visual__slide about-visual__slide--6"></span>
                    <span class="about-visual__slide about-visual__slide--7"></span>
                    <span class="about-visual__slide about-visual__slide--8"></span>
                    <span class="about-visual__slide about-visual__slide--9"></span>
                    <span class="about-visual__slide about-visual__slide--10"></span>
                    <span class="about-visual__slide about-visual__slide--11"></span>
                    <span class="about-visual__slide about-visual__slide--12"></span>
                    <span class="about-visual__slide about-visual__slide--13"></span>
                    <span class="about-visual__slide about-visual__slide--14"></span>
                </div>

                <div class="about-visual__controls" role="group" aria-label="Управление фотографиями">
                    <button type="button" class="about-visual__control" data-about-prev aria-label="Предыдущая фотография">‹</button>
                    <button type="button" class="about-visual__control about-visual__control--pause" data-about-pause aria-label="Остановить смену фотографий" aria-pressed="false">Ⅱ</button>
                    <button type="button" class="about-visual__control" data-about-next aria-label="Следующая фотография">›</button>
                </div>

                <div class="about-visual__caption">
                    <span>
                        Партенит · Южный берег Крыма
                    </span>

                    <strong>
                        Море. Природа. Восстановление.
                    </strong>
                </div>
            </div>

            <div class="about-content">

                <span class="section-eyebrow">
                    О санатории
                </span>

                <h2 id="about-title">
                    Место, где природа помогает восстановлению
                </h2>

                <p>
                    Военный санаторий «Крым» расположен
                    в живописной Партенитской долине
                    на Южном берегу Крыма, у подножия
                    легендарной Медведь-горы — Аю-Даг.
                </p>

                <p>
                    Санаторий окружён уникальным парком
                    площадью около 40 гектаров, в котором
                    произрастает более 160 видов
                    экзотических растений.
                </p>

                <p>
                    Благоприятный климат, морской воздух,
                    природные лечебные факторы и медицинская
                    база создают условия для комплексного
                    лечения, оздоровления и отдыха.
                </p>

                <div class="about-history">
                    <strong>С 1974 года</strong>

                    <span>
                        Центральный военный санаторий «Крым»
                        принимает отдыхающих на Южном берегу Крыма.
                    </span>
                </div>

            </div>
        </div>
    </section>


    <!-- ЛЕЧЕНИЕ -->
    <section
        class="treatment-section"
        id="treatment"
        aria-labelledby="treatment-title"
    >
        <div class="treatment-container">

            <div class="treatment-heading">
                <span class="section-eyebrow">
                    Медицинский профиль
                </span>

                <h2 id="treatment-title">
                    Санаторно-курортное лечение
                </h2>

                <p>
                    Медицинский профиль санатория охватывает
                    несколько направлений лечения и реабилитации.
                    Программы подбираются с учётом характера
                    заболевания и состояния здоровья отдыхающего.
                </p>
            </div>

            <div class="treatment-grid">

                <article class="treatment-card">
                    <span class="treatment-card__number">
                        01
                    </span>

                    <h3>Костно-мышечная система</h3>

                    <p>
                        Заболевания костно-мышечной системы
                        и соединительной ткани.
                    </p>
                </article>

                <article class="treatment-card">
                    <span class="treatment-card__number">
                        02
                    </span>

                    <h3>Система кровообращения</h3>

                    <p>
                        Санаторно-курортное лечение
                        при заболеваниях системы кровообращения.
                    </p>
                </article>

                <article class="treatment-card">
                    <span class="treatment-card__number">
                        03
                    </span>

                    <h3>Органы дыхания</h3>

                    <p>
                        Лечение заболеваний органов дыхания
                        нетуберкулёзного характера.
                    </p>
                </article>

                <article class="treatment-card">
                    <span class="treatment-card__number">
                        04
                    </span>

                    <h3>Нервная система</h3>

                    <p>
                        Заболевания центральной
                        и периферической нервной системы.
                    </p>
                </article>

                <article class="treatment-card">
                    <span class="treatment-card__number">
                        05
                    </span>

                    <h3>Мочеполовая система</h3>

                    <p>
                        Санаторно-курортное лечение
                        при заболеваниях мочеполовой системы.
                    </p>
                </article>

            </div>

            <div class="treatment-methods">
                <h3>Применяемые методы лечения</h3>

                <ul class="treatment-methods__list">
                    <li>Климатолечение</li>
                    <li>Бальнеолечение</li>
                    <li>Грязелечение</li>
                    <li>Физиотерапия</li>
                    <li>Лечебная физкультура</li>
                    <li>Лечебное питание</li>
                </ul>
            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>
