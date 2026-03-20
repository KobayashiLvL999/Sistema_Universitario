// public/script.js

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(event) {
        const inputs = this.querySelectorAll('input[required]');
        let valid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.style.borderColor = 'red';
                valid = false;
            } else {
                input.style.borderColor = '#ddd';
            }
        });

        if (!valid) {
            event.preventDefault();
            alert('Por favor, preencha todos os campos obrigatórios.');
        }
    });
});