let cities = [];
let selectedIndex = -1; // Pour suivre la suggestion actuellement sélectionnée

// Charger les villes à partir du fichier JSON
fetch('homepage/cities.json') // Chemin vers le fichier JSON
    .then(response => response.json())
    .then(data => {
        cities = data.cities.map(city => ({
            displayName: city.city_code.toUpperCase() + " (" + city.zip_code + ")", // Nom affiché en majuscules avec le code INSEE
            searchName: city.city_code.toLowerCase().replace(/-/g, ' ') + " " + city.zip_code // Nom de recherche (ville sans tirets et code postal)
        }));
    })
    .catch(error => console.error('Erreur de chargement des villes :', error));

const inputField = document.getElementById("citySearch");
const suggestionsDiv = document.getElementById("suggestions");

// Fonction pour construire l'URL de redirection
function getCityUrl(cityName) {
    return `/city/${cityName.replace(/\s+/g, '-').toLowerCase()}`;
}

inputField.addEventListener("input", function() {
    const query = this.value.toLowerCase().replace(/-/g, ' '); // Normaliser la saisie de l'utilisateur
    suggestionsDiv.innerHTML = "";
    selectedIndex = -1; // Réinitialiser l'index à chaque saisie

    // Définir le nombre de suggestions en fonction de la longueur du texte
    let maxSuggestions;
    if (query.length >= 4) {
        maxSuggestions = 10;
    } else if (query.length === 3) {
        maxSuggestions = 5;
    } else if (query.length === 2) {
        maxSuggestions = 2;
    } else {
        suggestionsDiv.style.display = "none";
        return; // Ne rien afficher si la recherche est trop courte
    }

    if (query.includes("paris")) {
        maxSuggestions = 30;
    }

    const filteredCities = cities.filter(city => city.searchName.includes(query));
    const limitedSuggestions = filteredCities.slice(0, maxSuggestions);

    limitedSuggestions.forEach((city, index) => {
        const suggestion = document.createElement("div");
        suggestion.textContent = city.displayName; // Afficher le nom avec INSEE en majuscules
        suggestion.classList.add("suggestion-item");

        // Clic sur une suggestion avec redirection
        suggestion.addEventListener("click", () => {
            const cityUrl = getCityUrl(city.displayName.replace(/ \(\d+\)$/, ''));
            window.location.href = cityUrl; // Redirection vers la page de la ville
        });

        suggestionsDiv.appendChild(suggestion);
    });

    suggestionsDiv.style.display = limitedSuggestions.length ? "block" : "none";
});

// Gestion de la navigation au clavier avec redirection
inputField.addEventListener("keydown", function(event) {
    const suggestionItems = document.querySelectorAll(".suggestion-item");

    if (event.key === "ArrowDown") {
        // Flèche bas pour avancer dans la liste
        selectedIndex = (selectedIndex + 1) % suggestionItems.length; // Revient au début si on dépasse la fin
        highlightSuggestion(suggestionItems);
        event.preventDefault();
    } else if (event.key === "ArrowUp") {
        // Flèche haut pour reculer dans la liste
        selectedIndex = (selectedIndex - 1 + suggestionItems.length) % suggestionItems.length; // Revient à la fin si on dépasse le début
        highlightSuggestion(suggestionItems);
        event.preventDefault();
    } else if (event.key === "Enter") {
        // Touche Entrée pour sélectionner la suggestion surlignée avec redirection
        if (selectedIndex >= 0 && selectedIndex < suggestionItems.length) {
            const selectedCity = suggestionItems[selectedIndex].textContent;
            const cityUrl = getCityUrl(selectedCity.replace(/ \(\d+\)$/, ''));
            window.location.href = cityUrl; // Redirection vers la page de la ville
        }
        event.preventDefault();
    }
});

// Fonction pour surligner la suggestion sélectionnées
function highlightSuggestion(suggestionItems) {
    suggestionItems.forEach((item, index) => {
        item.classList.toggle("highlighted", index === selectedIndex);
    });
}
