document.addEventListener("DOMContentLoaded", function() {

    // Limitação de caracteres para nome do produto e descrição
    const nameInput = document.getElementById("name");
    const descriptionInput = document.getElementById("description");
    const quantityInput = document.getElementById("quantity");
    const priceInput = document.getElementById("price");
    const form = document.querySelector("form");

    nameInput.addEventListener("input", function() {
        if (nameInput.value.length > 100) {
            nameInput.value = nameInput.value.substring(0, 100);
        }
    });

    descriptionInput.addEventListener("input", function() {
        if (descriptionInput.value.length > 500) {
            descriptionInput.value = descriptionInput.value.substring(0, 500);
        }
    });

    // Validação de quantidade
    quantityInput.addEventListener("input", function() {
        if (quantityInput.value < 0) {
            quantityInput.value = 0;
        }
        quantityInput.value = quantityInput.value.replace(/\D/, ''); // Permitir apenas números
    });

    // Validação de formulário antes do envio
    form.addEventListener("submit", function(event) {
        const productForms = document.querySelectorAll('.product-form');

        for (let i = 0; i < productForms.length; i++) {
            const name = productForms[i].querySelector('[name^="products["][name$="[name]"]');
            const price = productForms[i].querySelector('[name^="products["][name$="[price]"]');
            const quantity = productForms[i].querySelector('[name^="products["][name$="[quantity]"]');

            if (name.value.trim() === "" || price.value.trim() === "" || quantity.value.trim() === "") {
                alert('Por favor, preencha todos os campos obrigatórios antes de enviar.');
                event.preventDefault();
                return false;
            }
        }
    });

    // Adicionar novo produto dinamicamente
    let productIndex = 1;

    $('#add-product-btn').click(function() {
        $('#products-wrapper').append(`
            <div class="product-form mb-4 p-3 border rounded shadow-sm">
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="bi bi-basket"></i> Nome do Produto:
                    </label>
                    <input type="text" id="name" name="products[${productIndex}][name]" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">
                        <i class="bi bi-currency-dollar"></i> Preço:
                    </label>
                    <input type="number" step="0.01" id="price" name="products[${productIndex}][price]" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">
                        <i class="bi bi-123"></i> Quantidade:
                    </label>
                    <input type="number" id="quantity" name="products[${productIndex}][quantity]" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">
                        <i class="bi bi-textarea-t"></i> Descrição:
                    </label>
                    <textarea id="description" name="products[${productIndex}][description]" class="form-control" rows="4"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">
                        <i class="bi bi-image"></i> Imagem do Produto:
                    </label>
                    <input type="file" id="image" name="products[${productIndex}][image]" class="form-control" accept="image/*">
                </div>
            </div>
        `);

        productIndex++;
    });
});
