// Inicialização do mapa
var map = L.map('map').setView([0.03290647125848735, -51.08539767967154], 13);

var Stadia_AlidadeSmooth = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
    minZoom: 0,
    maxZoom: 20,
    attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    ext: 'png'
}).addTo(map);

// Definindo os ícones personalizados
var customIcon = L.icon({
    iconUrl: '/img/BANDEIRA-VERMELHA.png',
    iconSize: [50, 50],
    iconAnchor: [25, 50],
    popupAnchor: [0, -50]
});

var customPurpleIcon = L.icon({
    iconUrl: '/img/BANDEIRA-ROXA.png',
    iconSize: [50, 50],
    iconAnchor: [25, 50],
    popupAnchor: [0, -50]
});

var customGrayIcon = L.icon({
    iconUrl: '/img/BANDEIRA-CINZA.png',
    iconSize: [50, 50],
    iconAnchor: [25, 50],
    popupAnchor: [0, -50]
});

let currentImageIndex = 0;
let imagesArray = [];


function addMarker(point, icon) {
    const latLng = [parseFloat(point.latitude), parseFloat(point.longitude)];
    if (!icon) {
        icon = point.complemento.status === 0 ? customGrayIcon : customIcon;
    }

    const endereco = point.endereco;
    const popupText = `
        <div class="custom-popup">
            <strong>Nome:</strong> ${point.name}<br>
            <strong>Endereço:</strong> ${endereco ? `${endereco.logradouro}, ${endereco.numero}, ${endereco.bairro}, ${endereco.cidade} - ${endereco.estado}` : 'Endereço não disponível'}<br>
            <strong>CEP:</strong> ${endereco ? endereco.cep : 'CEP não disponível'}<br>
            <strong>Telefone:</strong> <a href="https://wa.me/${point.tel_contato}" target="_blank">${point.tel_contato}</a><br>
            <div class="button-container">
                <button class="btn btn-secondary see-more-btn" onclick="openDetailedPopup(${JSON.stringify(point).replace(/"/g, '&quot;')})">Ver mais</button>
            </div>
        </div>
    `;

    const marker = L.marker(latLng, { icon: icon }).addTo(map).bindPopup(popupText);
    marker.on('click', function() {
        marker.openPopup();
    });
}

// Carregar todos os pontos
fetch('/load-all-points')
    .then(response => response.json())
    .then(points => {
        window.points = points; // Armazena os pontos em uma variável global
        points.forEach(point => {
            addMarker(point, customIcon);
        });
    });

// Carregar os marcadores destacados
fetch('/highlighted-markers')
    .then(response => response.json())
    .then(highlightedPoints => {
        highlightedPoints.forEach(point => {
            addMarker(point, customPurpleIcon); // Usa o ícone roxo para os marcadores destacados
        });
    });

