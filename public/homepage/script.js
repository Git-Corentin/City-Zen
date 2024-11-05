let cities = [];
let selectedIndex = -1;
let limitedSuggestions = [];
let currentCountry = 'fr'; // Définition initiale (France)

const inputField = document.getElementById("citySearch");
const suggestionsDiv = document.getElementById("suggestions");
const countrySelect = document.getElementById("countrySelect");

// Fonction pour charger les villes en fonction du pays
function loadCities(countryCode) {
    fetch(`json_files/${countryCode === 'fr' ? 'french_cities' : 'australian_cities'}.json`)
        .then(response => response.json())
        .then(data => {
            if (countryCode === 'fr') {
                cities = data.cities.map(city => ({
                    displayName: city.city_code.toUpperCase() + " (" + (city.zip_code || "") + ")",
                    searchName: city.city_code.toLowerCase().replace(/-/g, ' ') + " " + (city.zip_code || ""),
                    latitude: city.latitude,
                    longitude: city.longitude

                }));
            }
            if (countryCode === 'au') {
                cities = data.cities.map(city => ({
                    displayName: city.city_code.toUpperCase(),
                    searchName: city.city_code.toLowerCase().replace(/-/g, ' '),
                    latitude: city.latitude,
                    longitude: city.longitude

                }));
            }

        })
        .catch(error => console.error('Erreur de chargement des villes :', error));
}

// Charger les villes initiales (France)
loadCities(currentCountry);

// Détecter le changement de pays et recharger les villes
countrySelect.addEventListener("change", () => {
    currentCountry = countrySelect.value;
    loadCities(currentCountry); // Recharger les villes pour le pays sélectionné
});

function getCityUrl(cityName, latitude, longitude) {
    return `/city/${countrySelect.value}/${cityName.replace(/\s+/g, '-').toLowerCase()}/${latitude}/${longitude}`;
}

inputField.addEventListener("input", function() {
    const query = this.value.toLowerCase().replace(/-/g, ' ');
    suggestionsDiv.innerHTML = "";
    selectedIndex = -1;

    let maxSuggestions;
    if (query.length >= 4) {
        maxSuggestions = 10;
    } else if (query.length === 3) {
        maxSuggestions = 5;
    } else if (query.length === 2) {
        maxSuggestions = 2;
    } else {
        suggestionsDiv.style.display = "none";
        return;
    }

    if (query.includes("paris")) {
        maxSuggestions = 30;
    }

    const filteredCities = cities.filter(city => city.searchName.includes(query));
    limitedSuggestions = filteredCities.slice(0, maxSuggestions);

    limitedSuggestions.forEach((city, index) => {
        const suggestion = document.createElement("div");
        suggestion.textContent = city.displayName;
        suggestion.classList.add("suggestion-item");

        suggestion.addEventListener("click", () => {
            const cityUrl = getCityUrl(
                city.displayName.replace(/ \(\d+\)$/, ''),
                city.latitude,
                city.longitude
            );
            window.location.href = cityUrl;
        });

        suggestionsDiv.appendChild(suggestion);
    });

    suggestionsDiv.style.display = limitedSuggestions.length ? "block" : "none";
});

inputField.addEventListener("keydown", function(event) {
    const suggestionItems = document.querySelectorAll(".suggestion-item");

    if (event.key === "ArrowDown") {
        selectedIndex = (selectedIndex + 1) % suggestionItems.length;
        highlightSuggestion(suggestionItems);
        event.preventDefault();
    } else if (event.key === "ArrowUp") {
        selectedIndex = (selectedIndex - 1 + suggestionItems.length) % suggestionItems.length;
        highlightSuggestion(suggestionItems);
        event.preventDefault();
    } else if (event.key === "Enter") {
        if (selectedIndex >= 0 && selectedIndex < suggestionItems.length) {
            const selectedCity = limitedSuggestions[selectedIndex];
            const cityUrl = getCityUrl(
                selectedCity.displayName.replace(/ \(\d+\)$/, ''),
                selectedCity.latitude,
                selectedCity.longitude
            );
            window.location.href = cityUrl;
        }
        event.preventDefault();
    }
});

function highlightSuggestion(suggestionItems) {
    suggestionItems.forEach((item, index) => {
        item.classList.toggle("highlighted", index === selectedIndex);
    });
}
