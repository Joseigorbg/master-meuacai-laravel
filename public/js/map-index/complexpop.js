function openDetailedPopup(point) {
    const complemento = point.complemento && Array.isArray(point.complemento) ? point.complemento[0] : null;
    if (!complemento) {
        console.error('Complemento não encontrado para o ponto:', point);
        return;
    }

    const statusColor = complemento.status === 1 ? 'green' : 'red';

    let daysHours = {};
    try {
        daysHours = complemento.days_hours ? JSON.parse(complemento.days_hours) : {};
    } catch (e) {
        console.error('Erro ao parsear days_hours:', e);
    }

    const days = daysHours.day || [];
    const hours = daysHours.hours || [];

    const daysString = days.length > 0 ? days.join(', ') : 'Sem dias definidos';
    const hoursString = hours.length > 0 ? hours.join(', ') : 'Sem horário definido';

    const imagesArray = complemento.images ? JSON.parse(complemento.images) : [];
    const videoSrc = complemento.videos ? JSON.parse(complemento.videos)[0] : '';

    const products = point.products || [];
    let productList = products.length > 0 
        ? products.map(product => `
            <li>
                <strong>${product.name}</strong> - ${product.price} 
                <small>(${product.quantity} disponíveis)</small>
            </li>
          `).join('')
        : '<li>Nenhum produto disponível</li>';

    let photoCollage = imagesArray.map((img, index) => `
        <div class="photo-collage-item" onclick="openImagePopup(${index})">
            <img src="${img}" alt="${point.name}">
        </div>
    `).join('');

    let detailedPopupContent = `
        <div class="detailed-popup">
            <div class="header">
                <button class="close-button btn btn-danger">×</button>
                <div class="top-row">
                    <h5>Ponto: ${point.name}</h5>
                    <div class="status-circle" style="background-color: ${statusColor};"></div>
                </div>
                <div class="marker-info">
                    <strong>Endereço:</strong> ${point.endereco.logradouro}, ${point.endereco.numero}, ${point.endereco.bairro}, ${point.endereco.cidade} - ${point.endereco.estado}<br>
                    <strong>CEP:</strong> ${point.endereco.cep}<br>
                    <strong>Horários:</strong> ${hoursString}<br>
                    <strong>Dias da Semana:</strong> ${daysString}<br>
                </div>
            </div>
            <div class="content">
                <div class="media-container">
                    <div class="photo-collage">
                        ${photoCollage}
                    </div>
                    <div class="video">
                        ${videoSrc ? `<button class="video-thumbnail" onclick="openVideoPopup('${videoSrc}')">Assistir Vídeo</button>` : ''}
                    </div>
                </div>
                <div class="product-list">
                    <h6>Produtos:</h6>
                    <ul>${productList}</ul>
                </div>
            </div>
            <div class="footer">
                <a href="https://wa.me/${point.tel_contato}" target="_blank" class="btn btn-success whatsapp-button">
                    <i class="fab fa-whatsapp"></i> ${point.tel_contato}
                </a>
                <div id="like-button-container"></div> 
            </div>
        </div>
    `;

    document.getElementById('modalContainer').innerHTML = detailedPopupContent;

    // Fechar o modal
    var closeButton = document.querySelector('.close-button');
    if (closeButton) {
        closeButton.addEventListener('click', () => {
            document.getElementById('modalContainer').innerHTML = '';
        });
    }

    // Criar o botão de Curtir
    const likeButtonContainer = document.getElementById('like-button-container');
    const likeButton = document.createElement('button');
    likeButton.className = 'btn btn-primary like-btn';
    likeButton.style.backgroundColor = 'purple';
    likeButton.innerHTML = `Curtir <span class="like-count"></span>`;
    
    likeButton.addEventListener('click', function() {
        if (likeButton.disabled) return;
    
        // Desabilitar o botão imediatamente
        likeButton.disabled = true;
    
        // Chamada AJAX para atualizar os likes no backend
        fetch(`/points/${point.id}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ like: true })
        }).then(response => {
            if (!response.ok) {
                throw new Error('Erro ao curtir o ponto.');
            }
            return response.json();
        }).then(data => {
            // Atualizar o contador de likes na interface
            likeButton.querySelector('.like-count').textContent = data.likes_count;
            console.log('Curtir atualizado com sucesso:', data);
        }).catch(error => {
            console.error('Erro ao atualizar curtida:', error);
            // Reverter a desabilitação do botão em caso de erro
            likeButton.disabled = false;
        });
    });    

    likeButtonContainer.appendChild(likeButton);
}
