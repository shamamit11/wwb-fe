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

document.addEventListener('DOMContentLoaded', () => {
    syncStickyHeader();
    setupMobileNav();

    window.addEventListener('scroll', syncStickyHeader, { passive: true });
});
