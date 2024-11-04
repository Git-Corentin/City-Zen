let cities = [];

// Charger les villes à partir du fichier JSON
fetch('homepage/cities.json') // Chemin vers le fichier JSON
    .then(response => response.json())
    .then(data => {
        cities = data.cities.map(city => ({
            displayName: city.city_code.toUpperCase() + " (" + city.zip_code + ")", // Nom affiché en majuscules avec l'INSEE
            searchName: city.city_code.toLowerCase().replace(/-/g, ' ') + " " + city.zip_code // Nom de recherche (ville sans tirets et code postal)
        }));
    })
    .catch(error => console.error('Erreur de chargement des villes :', error));

const inputField = document.getElementById("citySearch");
const suggestionsDiv = document.getElementById("suggestions");

inputField.addEventListener("input", function() {
    const query = this.value.toLowerCase().replace(/-/g, ' '); // Normaliser la saisie de l'utilisateur
    suggestionsDiv.innerHTML = "";

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

    limitedSuggestions.forEach(city => {
        const suggestion = document.createElement("div");
        suggestion.textContent = city.displayName; // Afficher le nom avec INSEE en majuscules
        suggestion.addEventListener("click", () => {
            inputField.value = city.displayName.replace(/ \(\d+\)$/, ''); // Remplit l'input sans le code INSEE
            suggestionsDiv.innerHTML = "";
            suggestionsDiv.style.display = "none";
        });
        suggestionsDiv.appendChild(suggestion);
    });

    suggestionsDiv.style.display = limitedSuggestions.length ? "block" : "none";

    if (limitedSuggestions.length === 1) {
        inputField.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                inputField.value = limitedSuggestions[0].displayName.replace(/ \(\d+\)$/, ''); // Remplit sans le code INSEE
                suggestionsDiv.innerHTML = "";
                suggestionsDiv.style.display = "none";
                event.preventDefault();
            }
        });
    }
});
