function addStation() {
    const container = document.getElementById('stations_container');
    const stations = container.getElementsByClassName('station-entry');
    const stationCount = stations.length;

    const newStation = document.createElement('div');
    newStation.className = 'station-entry';

    let html = `
    <div class="form-group">
        <label>Station Name</label>
        <input type="text" name="station_name[]" required>
    </div>`;

    // Arrival time: disabled for first station, enabled otherwise
    if (stationCount === 0) {
        html += `
        <div class="form-group">
            <label>Arrival Time</label>
            <input type="time" name="arrival_time[]" disabled>
        </div>`;
    } else {
        html += `
        <div class="form-group">
            <label>Arrival Time</label>
            <input type="time" name="arrival_time[]" required>
        </div>`;
    }

    // Departure time: always enabled for new station (will be disabled for last station after adding)
    html += `
    <div class="form-group">
        <label>Departure Time</label>
        <input type="time" name="departure_time[]" required>
    </div>`;

    newStation.innerHTML = html;
    container.appendChild(newStation);

    // Enable departure for previous last station
    if (stationCount > 0) {
        const previousLastStation = stations[stationCount - 1];
        const departureInput = previousLastStation.querySelector('input[name="departure_time[]"]');
        departureInput.disabled = false;
        departureInput.required = true;
    }

    // Disable departure for new last station
    const allStations = container.getElementsByClassName('station-entry');
    const lastStation = allStations[allStations.length - 1];
    const lastDeparture = lastStation.querySelector('input[name="departure_time[]"]');
    lastDeparture.disabled = true;
    lastDeparture.required = false;
}

// Initialize the first station
window.onload = function() {
    const stations = document.getElementsByClassName('station-entry');
    if (stations.length < 2) {
        addStation(); // Add second station if not present
    }

    // Disable arrival time for first station
    const firstStation = stations[0];
    const firstArrival = firstStation.querySelector('input[name="arrival_time[]"]');
    firstArrival.disabled = true;
    firstArrival.required = false;

    // Disable departure time for last station
    const lastStation = stations[stations.length - 1];
    const lastDeparture = lastStation.querySelector('input[name="departure_time[]"]');
    lastDeparture.disabled = true;
    lastDeparture.required = false;
}