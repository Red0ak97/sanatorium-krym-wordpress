(() => {
  'use strict';

  function ready(callback) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', callback, { once: true });
    } else {
      callback();
    }
  }

  ready(() => {
    const config = window.KrymRoomPhotos;
    if (!config || !config.categories) return;
    const rooms = config.categories;

    const normalize = value => String(value || '')
      .normalize('NFKC')
      .toLocaleLowerCase('ru-RU')
      .replace(/\u00a0/g, ' ')
      .replace(/ё/g, 'е');

    function identify(value) {
      const text = normalize(value);
      if (/люкс/.test(text) && /(?:2\s*[.,\-]\s*2|двухкомнат)/.test(text)) return 'luxe2-2';
      if (/(?:пк|pk)\s*[.\-_/ ]?\s*1\s*[.,\-_ ]\s*1(?:\D|$)/.test(text)) return 'pk1-1';
      if (/(?:пк|pk)\s*[.\-_/ ]?\s*1\s*[.,\-_ ]\s*2(?:\D|$)/.test(text)) return 'pk1-2';
      if (/(?:ст|st)\s*[.\-_/ ]?\s*1\s*[.,\-_ ]\s*2(?:\D|$)/.test(text)) return 'st1-2';
      if (/(?:чу|chu)\s*[.\-_/ ]?\s*1\s*[.,\-_ ]\s*1(?:\D|$)/.test(text)) return 'chu1-1';
      if (/(?:пк|pk)\s*[.\-_/ ]?\s*2\s*[.,\-_ ]\s*2(?:\D|$)/.test(text)) return 'pk2-2';
      if (/l(?:y|iu|ju)ks[\-_ ]?2[\-_.,]?2/.test(text)) return 'luxe2-2';
      return null;
    }

    // Leave all content, room descriptions and links as they were.
    // Change ONLY the placeholder thumbnail for room categories with supplied photos.
    document.querySelectorAll('.room-card').forEach(card => {
      const title = card.querySelector('.room-card__body h2, .room-card__body h3, h2, h3')?.textContent || '';
      const link = card.querySelector('a.room-card__link, a[href]');
      const key = identify(title) || identify(link?.getAttribute('href'));
      const media = card.querySelector('.room-card__media');
      if (!key || !media || !rooms[key]) return;
      // Don't overwrite a real photo an editor may have added.
      if (media.querySelector('img:not(.room-card__image.krp-image)')) return;
      if (media.querySelector('.krp-image')) return;
      const image = document.createElement('img');
      image.className = 'room-card__image krp-image';
      image.src = rooms[key].cover;
      image.alt = `Номер категории ${rooms[key].label}`;
      image.loading = 'lazy';
      image.decoding = 'async';
      media.replaceChildren(image);
    });

    const main = document.querySelector('main');
    const title = main?.querySelector('.inner-page__title, h1');
    const key = identify(title?.textContent || '');
    if (!key || !rooms[key] || !main || main.querySelector('.krp-gallery')) return;

    const content = main.querySelector('.inner-page__content') || main.querySelector('article') || main;
    const data = rooms[key];
    const section = document.createElement('section');
    section.className = 'krp-gallery';
    section.setAttribute('aria-label', `Фотографии номера ${data.label}`);
    const heading = document.createElement('h2');
    heading.className = 'krp-gallery__heading';
    heading.textContent = 'Фотографии номера';
    section.append(heading);

    const grid = document.createElement('div');
    grid.className = 'krp-gallery__grid';
    data.photos.forEach((src, index) => {
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'krp-gallery__thumb';
      button.setAttribute('aria-label', `Открыть фотографию ${index + 1} из ${data.photos.length}`);
      const img = document.createElement('img');
      img.src = src;
      img.loading = 'lazy';
      img.decoding = 'async';
      img.alt = `Номер ${data.label} — фотография ${index + 1}`;
      button.append(img);
      button.addEventListener('click', () => openDialog(index, button));
      grid.append(button);
    });
    section.append(grid);
    content.append(section);

    const modal = document.createElement('dialog');
    modal.className = 'krp-dialog';
    modal.setAttribute('aria-label', `Просмотр фотографий номера ${data.label}`);
    const inner = document.createElement('div');
    inner.className = 'krp-dialog__inner';
    const top = document.createElement('div');
    top.className = 'krp-dialog__top';
    const counter = document.createElement('span');
    counter.className = 'krp-dialog__counter';
    const close = document.createElement('button');
    close.type = 'button';
    close.className = 'krp-dialog__close';
    close.textContent = 'Закрыть ×';
    close.addEventListener('click', () => modal.close());
    top.append(counter, close);
    const image = document.createElement('img');
    image.className = 'krp-dialog__image';
    const nav = document.createElement('div');
    nav.className = 'krp-dialog__nav';
    const prev = document.createElement('button');
    prev.type = 'button';
    prev.textContent = '← Предыдущее';
    const next = document.createElement('button');
    next.type = 'button';
    next.textContent = 'Следующее →';
    nav.append(prev, next);
    inner.append(top, image, nav);
    modal.append(inner);
    document.body.append(modal);
    let current = 0;
    let opener = null;

    function render(index) {
      current = (index + data.photos.length) % data.photos.length;
      image.src = data.photos[current];
      image.alt = `Номер ${data.label} — фотография ${current + 1}`;
      counter.textContent = `Фото ${current + 1} из ${data.photos.length}`;
    }
    function openDialog(index, button) {
      opener = button;
      render(index);
      if (typeof modal.showModal === 'function') {
        modal.showModal();
      } else {
        // Very old browser fallback.
        modal.setAttribute('open', '');
      }
      close.focus();
    }
    prev.addEventListener('click', () => render(current - 1));
    next.addEventListener('click', () => render(current + 1));
    modal.addEventListener('keydown', event => {
      if (event.key === 'ArrowLeft') { event.preventDefault(); render(current - 1); }
      if (event.key === 'ArrowRight') { event.preventDefault(); render(current + 1); }
    });
    modal.addEventListener('click', event => {
      if (event.target === modal) modal.close();
    });
    modal.addEventListener('close', () => opener?.focus());
  });
})();
