function searchLocation(showFirst = false) {
    var input = document.querySelector('.searchInput');
    var suggestionsBox = document.getElementById('suggestionsBox');
    var query = input.value;
    var loading = document.getElementById('loading');
    
    if (!suggestionsBox) {
        console.error('Element "suggestionsBox" not found.');
        return;
    }

    if (query) {
        loading.style.display = 'block';
        var found = points.filter(point => point.name.toLowerCase().includes(query.toLowerCase()) || point.address.toLowerCase().includes(query.toLowerCase()));
        suggestionsBox.innerHTML = '';
        
        if (found.length > 0) {
            found.slice(0, 2).forEach((point, index) => {
                var latLng = [parseFloat(point.latitude), parseFloat(point.longitude)];
                var suggestion = document.createElement('div');
                suggestion.className = 'suggestion';
                suggestion.textContent = `${index + 1}. ${point.name}, ${point.address}`;
                suggestion.addEventListener('click', function() {
                    setViewAndOpenPopup(latLng, point.name + ", " + point.address, customIcon, point.id);
                    input.value = point.name + ", " + point.address;
                    suggestionsBox.innerHTML = '';
                });
                suggestionsBox.appendChild(suggestion);
            });
            if (showFirst) {
                var firstLatLng = [parseFloat(found[0].latitude), parseFloat(found[0].longitude)];
                setViewAndOpenPopup(firstLatLng, found[0].name + ", " + found[0].address, customIcon, found[0].id);
                input.value = found[0].name + ", " + found[0].address;
                suggestionsBox.innerHTML = '';
            }
        } else {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        data.slice(0, 2).forEach((location, index) => {
                            var suggestion = document.createElement('div');
                            suggestion.className = 'suggestion';
                            suggestion.textContent = `${index + 1}. ${location.display_name}`;
                            suggestion.addEventListener('click', function() {
                                setViewAndOpenPopup([parseFloat(location.lat), parseFloat(location.lon)], location.display_name, customIcon);
                                input.value = location.display_name;
                                suggestionsBox.innerHTML = '';
                            });
                            suggestionsBox.appendChild(suggestion);
                        });
                        if (showFirst) {
                            var firstLocation = data[0];
                            setViewAndOpenPopup([parseFloat(firstLocation.lat), parseFloat(firstLocation.lon)], firstLocation.display_name, customIcon);
                            input.value = firstLocation.display_name;
                            suggestionsBox.innerHTML = '';
                        }
                    }
                    loading.style.display = 'none';
                })
                .catch(error => {
                    console.error('Error fetching location from Nominatim:', error);
                    loading.style.display = 'none';
                });
        }
        loading.style.display = 'none';
    }
}

// Adiciona evento para disparar a função de pesquisa
document.querySelector('.searchInput').addEventListener('input', () => searchLocation(false));

