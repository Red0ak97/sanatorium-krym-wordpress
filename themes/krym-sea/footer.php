<footer class="site-footer" id="contacts">
    <div class="footer-container">

        <div class="footer-grid">

            <div class="footer-about">
                <h2>Военный санаторий «Крым»</h2>

                <p>
                    Федеральное государственное бюджетное
                    учреждение Министерства обороны
                    Российской Федерации.
                </p>

                <address>Демонстрационная версия · адрес не указан</address>
            </div>

            <div class="footer-contacts">
                <h2>Контакты</h2>

                <h3>Отделение реализации путёвок</h3>

                <span>Контакт скрыт в портфолио</span>

                <span>Контакт скрыт в портфолио</span>

                <span>Контакт скрыт в портфолио</span>

                <p>
                    Пн–пт: 08:00–16:12<br>
                    Обед: 13:00–14:00 (МСК)
                </p>
            </div>

            <div class="footer-info">
                <h2>Дополнительная информация</h2>

                <h3>Платные медицинские услуги</h3>

                <span>Контакт скрыт в портфолио</span>

                <p>Пн–пт: 08:00–15:00 (МСК)</p>

                <h3>Круглосуточная справочная</h3>

                <span>Контакт скрыт в портфолио</span>

                <h3>Обращения граждан</h3>

                <span>Контакт скрыт в портфолио</span>

                <p>
                    Не используется для подачи документов
                    на санаторно-курортное лечение.
                </p>
            </div>

        </div>

        <div class="footer-bottom">
            <p>
                © <?php echo esc_html(wp_date('Y')); ?>
                Военный санаторий «Крым».
                Все права защищены.
            </p>
        </div>

    </div>
</footer>


<!-- Версия сайта для слабовидящих -->
<div class="ks-accessibility">

    <div class="ks-a11y-launcher">
        <button
            type="button"
            class="ks-a11y-toggle"
            id="ks-a11y-toggle"
            aria-controls="ks-a11y-panel"
            aria-expanded="false"
            aria-pressed="false"
        >
            <span aria-hidden="true">◉</span>
            <span id="ks-a11y-label">Версия для слабовидящих</span>
        </button>

        <button
            type="button"
            class="ks-a11y-settings"
            id="ks-a11y-settings"
            aria-label="Открыть настройки доступности"
            aria-controls="ks-a11y-panel"
            aria-expanded="false"
            title="Настройки доступности"
        >
            <span aria-hidden="true">⚙</span>
        </button>
    </div>

    <section
        class="ks-a11y-panel"
        id="ks-a11y-panel"
        aria-label="Настройки отображения сайта"
        hidden
    >
        <h2>Настройки отображения</h2>

        <p>Размер текста</p>

        <div class="ks-a11y-controls">
            <button type="button" data-ks-action="smaller" aria-label="Уменьшить размер текста">
                А−
            </button>

            <button type="button" data-ks-action="larger" aria-label="Увеличить размер текста">
                А+
            </button>
        </div>

        <p>Цветовая схема</p>

        <div class="ks-a11y-controls">
            <button type="button" data-ks-action="light">
                Чёрный на белом
            </button>

            <button type="button" data-ks-action="dark">
                Белый на чёрном
            </button>
        </div>

        <p>Изображения</p>

        <div class="ks-a11y-controls">
            <button type="button" data-ks-action="images">
                Показать / скрыть
            </button>
        </div>

        <div class="ks-a11y-controls ks-a11y-controls--bottom">
            <button type="button" data-ks-action="reset">
                Обычная версия
            </button>

            <button type="button" data-ks-action="close">
                Закрыть
            </button>
        </div>

    </section>

</div>
<!-- Конец панели доступности -->


<?php wp_footer(); ?>
</body>
</html>
