// js/script.js

// 1. Confirmação personalizada para o Logout
const logoutBtn = document.getElementById('logoutBtn');
if (logoutBtn) {
    logoutBtn.addEventListener('click', function(e) {
        if (!confirm('Deseja realmente sair do sistema da Faculdade Vencer?')) {
            e.preventDefault(); // Cancela o clique se o usuário desistir
        }
    });
}

// 2. Efeito de destaque nas linhas da tabela ao passar o mouse
const rows = document.querySelectorAll('table tbody tr');
rows.forEach(row => {
    row.addEventListener('mouseover', () => {
        row.style.backgroundColor = '#eef2f7';
    });
    row.addEventListener('mouseout', () => {
        row.style.backgroundColor = '';
    });
});

// 3. Função para pesquisa simples na tabela (Filtro em tempo real)
const searchInput = document.querySelector('input[placeholder*="Pesquisar"]');
if (searchInput) {
    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
}