
document.addEventListener('DOMContentLoaded', () => {
    const burger = document.getElementById('burger');
    const header = document.querySelector('.site-header');
    const nav = document.getElementById('main-menu');

    if (!burger || !header || !nav) {
        return;
    }

    const closeMenu = () => {
        header.classList.remove('menu-active');
        burger.setAttribute('aria-expanded', 'false');
        burger.setAttribute('aria-label', 'Открыть меню');
    };

    burger.addEventListener('click', () => {
        const isOpen = header.classList.toggle('menu-active');

        burger.setAttribute('aria-expanded', String(isOpen));
        burger.setAttribute(
            'aria-label',
            isOpen ? 'Закрыть меню' : 'Открыть меню'
        );
    });

    nav.addEventListener('click', (event) => {
        if (event.target.closest('a')) {
            closeMenu();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMenu();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 1350) {
            closeMenu();
        }
    });
});
