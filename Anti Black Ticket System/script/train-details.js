document
  .getElementById("passengers_count")
  .addEventListener("input", function () {
    let referenceElement = this.parentElement;
    const passengerInputs = document.querySelectorAll(".passenger-input");
    passengerInputs.forEach((input) => input.remove());
    let count = this.value;
    for (let i = 0; i < count; i++) {
      let div = document.createElement("div");
      div.className = "form-group passenger-input";

      let label = document.createElement("label");
      label.innerHTML = `Passenger ${i + 1} Name:`;
      label.setAttribute("for", `passenger_${i + 1}`);

      let input = document.createElement("input");
      input.type = "text";
      input.id = `passenger_${i + 1}`;
      input.name = "passenger_names[]";
      input.required = true;

      div.appendChild(label);
      div.appendChild(input);

      // Insert after the reference element
      referenceElement.parentNode.insertBefore(
        div,
        referenceElement.nextSibling
      );
      referenceElement = div;
    }
  });
const classSelect = document.getElementById("class");
const fromStation = document.getElementById("from_station");
const toStation = document.getElementById("to_station");
const travelDate = document.getElementById("travel_date");
const passengersCount = document.getElementById("passengers_count");
const fareDisplay = document.getElementById("fareDisplay");
const fareInput = document.getElementById("fare");

// Station schedule data

function updateTravelDateMin() {
  const selectedFromStation = fromStation.value;
  const selectedToStation = toStation.value;

  let fromStationData = stationSchedule.find(
    (s) => s.station_name === selectedFromStation
  );
  let toStationData = stationSchedule.find(
    (s) => s.station_name === selectedToStation
  );

  if (!fromStationData || !toStationData) return;

  // Create new Date object for current date/time
  const now = new Date();
  const today = now.toISOString().split("T")[0];

  // Get current time in hours and minutes
  const currentHours = now.getHours();
  const currentMinutes = now.getMinutes();

  // Get departure time hours and minutes
  const [depHours, depMinutes] = fromStationData.departure_time.split(":");

  // Check if today's departure time has passed
  const departureHasPassed =
    currentHours > parseInt(depHours) ||
    (currentHours === parseInt(depHours) &&
      currentMinutes > parseInt(depMinutes));

  // If departure time has passed for today, set minimum to tomorrow
  if (departureHasPassed) {
    const tomorrow = new Date(now.setDate(now.getDate() + 1))
      .toISOString()
      .split("T")[0];
    travelDate.min = tomorrow;
    if (travelDate.value === today) {
      travelDate.value = tomorrow;
    }
  } else {
    travelDate.min = today;
  }

  // Check for midnight crossing
  const fromTime = new Date(`2000-01-01 ${fromStationData.departure_time}`);
  const toTime = new Date(`2000-01-01 ${toStationData.arrival_time}`);

  if (toTime < fromTime) {
    // If destination is after midnight, ensure next day is selected
    const tomorrow = new Date(now.setDate(now.getDate() + 1))
      .toISOString()
      .split("T")[0];
    travelDate.min = tomorrow;
    if (travelDate.value === today) {
      travelDate.value = tomorrow;
    }
  }
}

function updateToStationOptions() {
  const selectedFromStation = fromStation.value;
  const fromStationIndex = stationSchedule.findIndex(
    (s) => s.station_name === selectedFromStation
  );

  // Clear existing options
  toStation.innerHTML = "";

  // Add only stations that come after the selected "from" station
  stationSchedule.forEach((station, index) => {
    if (index > fromStationIndex) {
      const option = new Option(station.station_name, station.station_name);
      toStation.add(option);
    }
  });
}

function calculateFare() {
  const selectedClass = classSelect.value;
  const selectedFrom = fromStation.value;
  const selectedTo = toStation.value;
  const passengers = parseInt(passengersCount.value) || 0;

  if (!selectedClass || !selectedFrom || !selectedTo || passengers === 0) {
    fareDisplay.textContent = "Fare: ৳ 00.00";
    return;
  }

  // Get base fare from data attribute
  const baseFare = parseFloat(
    classSelect.options[classSelect.selectedIndex].dataset.baseFare
  );

  // Find station indices to calculate stops
  const fromIndex = stationSchedule.findIndex(
    (s) => s.station_name === selectedFrom
  );
  const toIndex = stationSchedule.findIndex(
    (s) => s.station_name === selectedTo
  );
  const stopCount = Math.abs(toIndex - fromIndex);

  // Get stop_order for from and to stations
  const fromStationObj = stationSchedule.find(s => s.station_name === selectedFrom);
  const toStationObj = stationSchedule.find(s => s.station_name === selectedTo);
  const fromStopOrder = fromStationObj ? parseInt(fromStationObj.stop_order) : 0;
  const toStopOrder = toStationObj ? parseInt(toStationObj.stop_order) : 0;
  const stopOrderDiff = Math.abs(toStopOrder - fromStopOrder);

  // Calculate fare using the new formula
  const fare = (baseFare * trainRate * passengers * stopOrderDiff ) ;
  // Display fare with 2 decimal places
  fareDisplay.textContent = `Fare: ৳ ${fare.toFixed(2)}`;
  fareInput.value = fare.toFixed(2);
}

// Add event listeners for fare calculation
classSelect.addEventListener("change", calculateFare);
fromStation.addEventListener("change", calculateFare);
toStation.addEventListener("change", calculateFare);
passengersCount.addEventListener("input", calculateFare);
// Add event listener for from_station changes
fromStation.addEventListener("change", function () {
  updateToStationOptions();
  updateTravelDateMin();
});

// Initial update
updateTravelDateMin();
updateToStationOptions();
