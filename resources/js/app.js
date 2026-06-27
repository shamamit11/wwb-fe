import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

const syncStickyHeader = () => {
    const header = document.querySelector('[data-site-header]');

    if (!header) {
        return;
    }

    if (window.scrollY > 24) {
        header.classList.add('bg-white/95', 'shadow-lg', 'shadow-slate-900/5');
        header.classList.remove('bg-white/80');

        return;
    }

    header.classList.add('bg-white/80');
    header.classList.remove('bg-white/95', 'shadow-lg', 'shadow-slate-900/5');
};

const setupSearchDialog = () => {
    const dialog = document.querySelector('[data-search-dialog]');
    const input = dialog?.querySelector('[data-search-input]');
    const openButtons = document.querySelectorAll('[data-search-open]');
    const closeButtons = dialog?.querySelectorAll('[data-search-close]');

    if (!dialog || !input || openButtons.length === 0 || !closeButtons) {
        return;
    }

    const open = () => {
        dialog.classList.remove('hidden');
        dialog.classList.remove('pointer-events-none');
        document.body.classList.add('overflow-hidden');
        window.setTimeout(() => input.focus(), 20);
    };

    const close = () => {
        dialog.classList.add('hidden');
        dialog.classList.add('pointer-events-none');
        document.body.classList.remove('overflow-hidden');
    };

    openButtons.forEach((button) => {
        if (button.dataset.searchOpenBound === 'true') {
            return;
        }

        button.dataset.searchOpenBound = 'true';
        button.addEventListener('click', open);
    });

    closeButtons.forEach((button) => {
        if (button.dataset.searchCloseBound === 'true') {
            return;
        }

        button.dataset.searchCloseBound = 'true';
        button.addEventListener('click', close);
    });

    if (document.body.dataset.searchEscapeBound === 'true') {
        return;
    }

    document.body.dataset.searchEscapeBound = 'true';
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            close();
        }
    });
};

const initializeSiteChrome = () => {
    syncStickyHeader();
    setupSearchDialog();
};

document.addEventListener('DOMContentLoaded', () => {
    initializeSiteChrome();
    window.addEventListener('scroll', syncStickyHeader, { passive: true });
});

document.addEventListener('livewire:navigated', () => {
    initializeSiteChrome();
});

Livewire.start();
