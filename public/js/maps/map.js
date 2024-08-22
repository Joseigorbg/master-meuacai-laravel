document.addEventListener("DOMContentLoaded", function() {
    var initialLat = 0.027465819260582135;
    var initialLon = -51.074237823486335;

    // Inicialize os valores iniciais dos campos de latitude e longitude
    document.getElementById('latitude').value = initialLat;
    document.getElementById('longitude').value = initialLon;

    // Crie o mapa Leaflet
    var map = L.map('map').setView([initialLat, initialLon], 13);

    L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
        minZoom: 0,
        maxZoom: 20,
        attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        ext: 'png'
    }).addTo(map);

    var customIcon = L.icon({
        iconUrl: '/img/BANDEIRA-ROXA.png',
        iconSize: [50, 50],
        iconAnchor: [25, 50],
        popupAnchor: [0, -50]
    });

    var marker = L.marker([initialLat, initialLon], { icon: customIcon, draggable: true }).addTo(map);

    // Atualize as coordenadas ao mover o marcador
    marker.on('moveend', function(e) {
        var newLatLng = e.target.getLatLng();
        document.getElementById('latitude').value = newLatLng.lat;
        document.getElementById('longitude').value = newLatLng.lng;

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${newLatLng.lat}&lon=${newLatLng.lng}`)
            .then(response => response.json())
            .then(data => {
                formatAddress(data);
            })
            .catch(error => console.error('Erro ao obter o endereço:', error));
    });

    // Botão "Estou aqui" para geolocalização
    document.getElementById('locateButton').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lon;

                if (marker) {
                    map.removeLayer(marker);
                }

                marker = L.marker([lat, lon], { icon: customIcon, draggable: true }).addTo(map);
                map.setView([lat, lon], 13);

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                    .then(response => response.json())
                    .then(data => {
                        formatAddress(data);
                    })
                    .catch(error => console.error('Erro ao obter o endereço:', error));

                marker.on('moveend', function(e) {
                    var newLatLng = e.target.getLatLng();
                    document.getElementById('latitude').value = newLatLng.lat;
                    document.getElementById('longitude').value = newLatLng.lng;

                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${newLatLng.lat}&lon=${newLatLng.lng}`)
                        .then(response => response.json())
                        .then(data => {
                            formatAddress(data);
                        })
                        .catch(error => console.error('Erro ao obter o endereço:', error));
                });
            }, function(error) {
                console.error('Erro ao obter localização:', error);
            });
        } else {
            alert('Geolocalização não é suportada pelo seu navegador.');
        }
    });

    // Função para formatar e preencher o campo de endereço e CEP
    function formatAddress(data) {
        if (data && data.address) {
            var address = data.address;
            var displayAddress = [
                address.road || '',
                address.house_number || '',
                address.suburb || '',
                address.city || '',
                address.state || '',
                address.region || '',
                address.postcode || '',
                address.country || ''
            ];

            displayAddress = displayAddress.filter(part => part.trim() !== '').join(', ');

            document.getElementById('logradouro').value = address.road || '';
            document.getElementById('bairro').value = address.suburb || '';
            document.getElementById('cidade').value = address.city || '';
            document.getElementById('estado').value = address.state || '';
            document.getElementById('cep').value = address.postcode || '';
            document.getElementById('pais').value = address.country || 'Brasil';
        }
    }
});
