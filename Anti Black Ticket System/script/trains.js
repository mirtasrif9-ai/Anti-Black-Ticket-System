// Station validation
document.getElementById("search-form").addEventListener("submit", function (e) {
  const fromStation = document.getElementById("from").value;
  const toStation = document.getElementById("to").value;

  if ((fromStation && !toStation) || (!fromStation && toStation)) {
    e.preventDefault();
    alert("Please select both From and To stations or leave both empty");
  }
});

// Category filtering
const categoryChips = document.querySelectorAll(".category-chip");
const trainRows = document.querySelectorAll(".results-table tbody tr");
const urlParams = new URLSearchParams(window.location.search);
const activeCategory = urlParams.get("category") || "all";
function filterRows(category) {
  trainRows.forEach((row) => {
    row.classList.toggle(
      "hidden",
      category !== "all" && row.dataset.category !== category
    );
  });
}

// Set active category on page load
categoryChips.forEach((chip) => {
  if (chip.dataset.category === activeCategory) {
    chip.classList.add("active");
    filterRows(activeCategory);
  }

  chip.addEventListener("click", () => {
    categoryChips.forEach((c) => c.classList.remove("active"));
    chip.classList.add("active");
    filterRows(chip.dataset.category);
  });
});
