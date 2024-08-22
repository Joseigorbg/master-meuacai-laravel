document.addEventListener('DOMContentLoaded', function () {
    const deleteForms = document.querySelectorAll('form[action*="points.destroy"]');

    deleteForms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Previne o envio do formulário

            if (confirm('Tem certeza de que deseja excluir este ponto?')) {
                form.submit(); // Submete o formulário se o usuário confirmar
            }
        });
    });
});
function confirmDelete() {
    return confirm("Tem certeza de que deseja excluir este ponto?");
}