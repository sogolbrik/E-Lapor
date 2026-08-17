import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()

// Import Leaflet CSS and JS (ensure these are included in your HTML or bundled appropriately)
// Initialize Leaflet map instance
let map;
function initLeafletMap(containerId = 'map', lat = -6.2, lng = 106.8, zoom = 13) {
    // Create map container
    map = L.map(containerId).setView([lat, lng], zoom);

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    return map;
}

// Initialize map when Alpine is ready
Alpine.effect(() => {
    if (document.getElementById('map')) {
        initLeafletMap();
    }
});
