/*
 * Версия для слабовидящих — тема krym-sea.
 * Основная кнопка: включить / выключить.
 * Кнопка с шестерёнкой: показать / скрыть настройки.
 * Работает со стилями .ks-a11y-* из assets/css/main.css.
 */
(() => {
    'use strict';

    function initAccessibility() {
        const toggle = document.getElementById('ks-a11y-toggle');
        const settingsButton = document.getElementById('ks-a11y-settings');
        const buttonLabel = document.getElementById('ks-a11y-label');
        const panel = document.getElementById('ks-a11y-panel');

        if (!toggle || !settingsButton || !buttonLabel || !panel) return;

        const root = document.documentElement;
        const storageKey = 'krym-sea-accessibility';
        const defaults = {
            enabled: false,
            size: 1.25,
            theme: 'light',
            hideImages: false
        };

        let stored = null;
        try {
            stored = JSON.parse(localStorage.getItem(storageKey) || 'null');
        } catch (_) {
            // В приватном режиме хранилище может быть недоступно.
        }

        const validStored = stored !== null &&
            typeof stored === 'object' && !Array.isArray(stored);

        const settings = {
            enabled: validStored && stored.enabled === true,
            size: validStored && Number.isFinite(stored.size)
                ? Math.min(1.5, Math.max(1, stored.size))
                : defaults.size,
            theme: validStored && stored.theme === 'dark' ? 'dark' : 'light',
            hideImages: validStored && stored.hideImages === true
        };

        let focusReturn = toggle;

        function save() {
            try {
                localStorage.setItem(storageKey, JSON.stringify(settings));
            } catch (_) {
                // Настройки действуют до обновления страницы и без хранилища.
            }
        }

        function render() {
            root.classList.toggle('ks-a11y-mode', settings.enabled);
            root.classList.toggle(
                'ks-a11y-light', settings.enabled && settings.theme === 'light'
            );
            root.classList.toggle(
                'ks-a11y-dark', settings.enabled && settings.theme === 'dark'
            );
            root.classList.toggle(
                'ks-a11y-hide-images', settings.enabled && settings.hideImages
            );

            root.style.setProperty(
                '--ks-font-scale', settings.enabled ? String(settings.size) : '1'
            );

            toggle.setAttribute('aria-pressed', String(settings.enabled));
            buttonLabel.textContent = settings.enabled
                ? 'Выключить спецверсию'
                : 'Версия для слабовидящих';

            for (const button of panel.querySelectorAll('[data-ks-action]')) {
                const action = button.dataset.ksAction;

                if (action === 'light' || action === 'dark') {
                    button.setAttribute('aria-pressed', String(
                        settings.enabled && settings.theme === action
                    ));
                } else if (action === 'images') {
                    button.setAttribute('aria-pressed', String(
                        settings.enabled && settings.hideImages
                    ));
                    button.textContent = settings.hideImages && settings.enabled
                        ? 'Показать изображения'
                        : 'Скрыть изображения';
                }
            }
        }

        function setPanelOpen(open, restoreFocus = true) {
            panel.hidden = !open;
            toggle.setAttribute('aria-expanded', String(open));
            settingsButton.setAttribute('aria-expanded', String(open));
            settingsButton.setAttribute(
                'aria-label', open ? 'Закрыть настройки доступности' : 'Открыть настройки доступности'
            );

            if (open) {
                const firstControl = panel.querySelector('button');
                if (firstControl) firstControl.focus();
            } else if (restoreFocus) {
                focusReturn.focus();
            }
        }

        // Первая кнопка — включить; повторное нажатие — обычная версия.
        toggle.addEventListener('click', () => {
            focusReturn = toggle;
            settings.enabled = !settings.enabled;
            render();
            save();
            setPanelOpen(settings.enabled);
        });

        // Шестерёнка управляет панелью отдельно от главной кнопки.
        settingsButton.addEventListener('click', () => {
            focusReturn = settingsButton;
            const opening = panel.hidden;

            if (opening && !settings.enabled) {
                settings.enabled = true;
                render();
                save();
            }
            setPanelOpen(opening);
        });

        panel.addEventListener('click', (event) => {
            const button = event.target.closest('button[data-ks-action]');
            if (!button || !panel.contains(button)) return;

            const action = button.dataset.ksAction;

            if (action === 'close') {
                setPanelOpen(false);
                return;
            }

            if (action === 'reset') {
                Object.assign(settings, defaults);
                try {
                    localStorage.removeItem(storageKey);
                } catch (_) {
                    // Хранилище может быть недоступно.
                }
                render();
                focusReturn = toggle;
                setPanelOpen(false);
                return;
            }

            settings.enabled = true;
            switch (action) {
                case 'larger':
                    settings.size = Math.min(
                        1.5, Math.round((settings.size + 0.125) * 1000) / 1000
                    );
                    break;
                case 'smaller':
                    settings.size = Math.max(
                        1, Math.round((settings.size - 0.125) * 1000) / 1000
                    );
                    break;
                case 'light':
                case 'dark':
                    settings.theme = action;
                    break;
                case 'images':
                    settings.hideImages = !settings.hideImages;
                    break;
                default:
                    return;
            }
            render();
            save();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !panel.hidden) {
                setPanelOpen(false);
            }
        });

        // Восстановление ранее выбранного режима на всех страницах сайта.
        render();
        panel.hidden = true;
        toggle.setAttribute('aria-expanded', 'false');
        settingsButton.setAttribute('aria-expanded', 'false');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAccessibility);
    } else {
        initAccessibility();
    }
})();