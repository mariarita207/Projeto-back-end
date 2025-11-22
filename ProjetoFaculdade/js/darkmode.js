const trilho = document.getElementById('trilho');
const body = document.body;

// --- Ativar darkmode ---
function enableDark() {
    body.classList.add('dark');
    trilho.classList.add('dark');
    localStorage.setItem('theme', 'dark');
}

// --- Desativar darkmode ---
function disableDark() {
    body.classList.remove('dark');
    trilho.classList.remove('dark');
    localStorage.setItem('theme', 'light');
}

// --- Alternar ao clicar ---
trilho.addEventListener('click', () => {
    body.classList.contains('dark') ? disableDark() : enableDark();
});

// --- Aplicar tema salvo ao carregar ---
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');

    if (savedTheme === 'dark') {
        enableDark();
    } else {
        disableDark();
    }
});