let trilho = document.getElementById('trilho')
let body = document.querySelector('body')


trilho.addEventListener('click', ()=>{
trilho.classList.toggle('dark')
body.classList.toggle('dark')

 // Salva o estado no localStorage
if (body.classList.contains('dark')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }

})

// Ao carregar a página, aplica o tema salvo
window.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    
    if (savedTheme === 'dark') {
        document.body.classList.add('dark');
        document.getElementById('trilho').classList.add('dark');
    }
});
