/* Слайд-шоу фото в секции «О санатории». Без зависимостей. */
(() => {
    'use strict';

    document.addEventListener('DOMContentLoaded', () => {
        const gallery = document.querySelector('.about-visual');
        if (!gallery) return;

        const slides = [...gallery.querySelectorAll('.about-visual__slide')];
        const prev = gallery.querySelector('[data-about-prev]');
        const next = gallery.querySelector('[data-about-next]');
        const pause = gallery.querySelector('[data-about-pause]');
        if (slides.length < 2 || !prev || !next || !pause) return;

        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        let active = 0;
        let paused = reduceMotion.matches;
        let hovered = false;
        let focused = false;
        let interval = null;

        function render() {
            slides.forEach((slide, index) => {
                slide.classList.toggle('is-active', index === active);
            });
            pause.textContent = paused ? '▶' : 'Ⅱ';
            pause.setAttribute('aria-pressed', String(paused));
            pause.setAttribute('aria-label', paused
                ? 'Продолжить автоматическую смену фотографий'
                : 'Остановить смену фотографий');
        }

        function stop() {
            if (interval !== null) {
                window.clearInterval(interval);
                interval = null;
            }
        }

        function start() {
            stop();
            if (paused || hovered || focused || document.hidden) return;
            interval = window.setInterval(() => {
                active = (active + 1) % slides.length;
                render();
            }, 5000);
        }

        function move(direction) {
            active = (active + direction + slides.length) % slides.length;
            render();
            start();
        }

        prev.addEventListener('click', () => move(-1));
        next.addEventListener('click', () => move(1));
        pause.addEventListener('click', () => {
            paused = !paused;
            render();
            start();
        });

        gallery.addEventListener('mouseenter', () => {
            hovered = true;
            stop();
        });
        gallery.addEventListener('mouseleave', () => {
            hovered = false;
            start();
        });
        gallery.addEventListener('focusin', () => {
            focused = true;
            stop();
        });
        gallery.addEventListener('focusout', () => {
            // Prevent a brief restart when focus moves between controls.
            window.requestAnimationFrame(() => {
                focused = gallery.contains(document.activeElement);
                start();
            });
        });
        document.addEventListener('visibilitychange', start);
        reduceMotion.addEventListener('change', (event) => {
            paused = event.matches;
            render();
            start();
        });

        render();
        start();
    });
})();
