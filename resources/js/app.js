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

const setupMobileNav = () => {
    const toggle = document.querySelector('[data-mobile-toggle]');
    const nav = document.querySelector('[data-mobile-nav]');

    if (!toggle || !nav) {
        return;
    }

    toggle.addEventListener('click', () => {
        const isExpanded = toggle.getAttribute('aria-expanded') === 'true';

        toggle.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
        nav.classList.toggle('hidden', isExpanded);
    });
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
        button.addEventListener('click', open);
    });

    closeButtons.forEach((button) => {
        button.addEventListener('click', close);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            close();
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    syncStickyHeader();
    setupMobileNav();
    setupSearchDialog();

    window.addEventListener('scroll', syncStickyHeader, { passive: true });
});

Livewire.start();
