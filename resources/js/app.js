import './bootstrap';
import * as Turbo from '@hotwired/turbo';

Turbo.start();

function updateAdminNavigation() {
    const currentPath = window.location.pathname.replace(/\/$/, '') || '/';

    document.querySelectorAll('[data-admin-nav]').forEach((link) => {
        const linkPath = new URL(link.href, window.location.origin).pathname.replace(/\/$/, '') || '/';
        link.classList.toggle('admin-nav-link-active', linkPath === currentPath);
    });
}

document.addEventListener('turbo:load', updateAdminNavigation);
document.addEventListener('turbo:render', updateAdminNavigation);
document.addEventListener('click', (event) => {
    const link = event.target.closest('[data-admin-nav]');

    if (!link) {
        return;
    }

    window.scrollTo({ top: 0, left: 0, behavior: 'auto' });

    document.querySelectorAll('[data-admin-nav]').forEach((item) => {
        item.classList.toggle('admin-nav-link-active', item === link);
    });
});

document.addEventListener('turbo:render', () => {
    if (window.location.pathname.startsWith('/admin')) {
        window.scrollTo({ top: 0, left: 0, behavior: 'auto' });
    }
});

const randomPortraits = {
    men: [3, 7, 11, 19, 22, 32, 41, 46, 52, 63, 75, 83],
    women: [5, 10, 17, 26, 32, 44, 47, 58, 65, 72, 79, 90],
};

const platformTemplates = [
    {
        vision: 'Mewujudkan desa yang transparan, aman, dan maju melalui pelayanan publik berbasis data.',
        mission: 'Meningkatkan kualitas pelayanan administrasi warga.\nMendorong transparansi anggaran dan kegiatan desa.\nMemperkuat keamanan lingkungan dan partisipasi pemuda.\nMengembangkan program ekonomi kreatif berbasis potensi lokal.',
    },
    {
        vision: 'Membangun desa yang mandiri, rukun, dan sejahtera dengan tata kelola yang bersih.',
        mission: 'Mempercepat layanan warga melalui sistem digital sederhana.\nMenguatkan kegiatan pendidikan, kesehatan, dan sosial masyarakat.\nMembuka ruang aspirasi warga secara rutin.\nMendukung UMKM dan kegiatan produktif warga.',
    },
    {
        vision: 'Menjadikan desa sebagai lingkungan yang inklusif, tertib, dan siap menghadapi perkembangan teknologi.',
        mission: 'Meningkatkan akurasi data warga untuk dasar kebijakan.\nMenyediakan program pelatihan keterampilan bagi masyarakat.\nMenjaga ketertiban dan keamanan melalui kolaborasi warga.\nMemastikan program desa berjalan terukur dan dapat diaudit.',
    },
];

document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-random-photo]');

    if (!button) {
        return;
    }

    const form = button.closest('form');
    const targetId = button.dataset.photoTarget;
    const targetInput = targetId ? document.getElementById(targetId) : null;
    const gender = form?.querySelector('[data-photo-gender]')?.value || 'men';
    const pool = randomPortraits[gender] || randomPortraits.men;
    const imageNumber = pool[Math.floor(Math.random() * pool.length)];

    if (targetInput) {
        targetInput.value = `https://randomuser.me/api/portraits/${gender}/${imageNumber}.jpg`;
        targetInput.dispatchEvent(new Event('input', { bubbles: true }));
    }
});

document.addEventListener('submit', (event) => {
    const form = event.target.closest('[data-login-form]');

    if (!form) {
        return;
    }

    const button = form.querySelector('[data-login-button]');
    const spinner = form.querySelector('[data-login-spinner]');
    const label = form.querySelector('[data-login-label]');
    const overlay = document.querySelector('[data-login-overlay]');

    if (button) {
        button.disabled = true;
    }

    if (spinner) {
        spinner.classList.remove('hidden');
    }

    if (label) {
        label.textContent = 'Memverifikasi...';
    }

    if (overlay) {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
    }
});

document.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-candidate-lookup]');

    if (!button) {
        return;
    }

    const form = button.closest('form');
    const lookupInput = form?.querySelector('[data-candidate-lookup-input]');
    const message = form?.querySelector('[data-candidate-lookup-message]');
    const targetInput = button.dataset.nameTarget ? document.getElementById(button.dataset.nameTarget) : form?.querySelector('[name="name"]');
    const identityNumber = lookupInput?.value.trim();

    if (!identityNumber) {
        if (message) {
            message.textContent = 'Masukkan NIK/NIM calon terlebih dahulu.';
            message.className = 'mt-2 text-xs font-semibold text-amber-600';
        }

        return;
    }

    button.disabled = true;
    button.textContent = 'Mencari...';

    try {
        const response = await fetch(`/admin/voters/lookup?identity_number=${encodeURIComponent(identityNumber)}`, {
            headers: {
                Accept: 'application/json',
            },
        });
        const payload = await response.json();

        if (!response.ok) {
            throw new Error(payload.message || 'Data pemilih tidak ditemukan.');
        }

        if (targetInput) {
            targetInput.value = payload.full_name;
            targetInput.dispatchEvent(new Event('input', { bubbles: true }));
        }

        if (message) {
            message.textContent = `${payload.full_name} ditemukan dari ${payload.region}.`;
            message.className = 'mt-2 text-xs font-semibold text-emerald-700';
        }
    } catch (error) {
        if (message) {
            message.textContent = error.message;
            message.className = 'mt-2 text-xs font-semibold text-rose-600';
        }
    } finally {
        button.disabled = false;
        button.textContent = 'Ambil Data';
    }
});

document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-auto-platform]');

    if (!button) {
        return;
    }

    const form = button.closest('form');
    const visionInput = form?.querySelector('[name="vision"]');
    const missionInput = form?.querySelector('[name="mission"]');
    const template = platformTemplates[Math.floor(Math.random() * platformTemplates.length)];

    if (visionInput) {
        visionInput.value = template.vision;
        visionInput.dispatchEvent(new Event('input', { bubbles: true }));
    }

    if (missionInput) {
        missionInput.value = template.mission;
        missionInput.dispatchEvent(new Event('input', { bubbles: true }));
    }
});
