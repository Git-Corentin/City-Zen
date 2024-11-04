let cities = [];

// Charger les villes à partir du fichier JSON
fetch('homepage/cities.json') // Chemin vers le fichier JSON
    .then(response => response.json())
    .then(data => {
        cities = data.cities.map(city => city.label.toLowerCase()); // stocker les noms en minuscules pour la recherche
    })
    .catch(error => console.error('Erreur de chargement des villes :', error));

// Fonction pour mettre en majuscule les premières lettres de chaque mot
function capitalizeWords(str) {
    return str.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
}

const inputField = document.getElementById("citySearch");
const suggestionsDiv = document.getElementById("suggestions");

inputField.addEventListener("input", function() {
    const query = this.value.toLowerCase();
    suggestionsDiv.innerHTML = "";

    if (query.length >= 2) {
        const filteredCities = cities.filter(city => city.includes(query));
        const limitedSuggestions = filteredCities.slice(0, 10);

        limitedSuggestions.forEach(city => {
            const suggestion = document.createElement("div");
            suggestion.textContent = capitalizeWords(city); // Afficher avec premières lettres en majuscule
            suggestion.addEventListener("click", () => {
                inputField.value = capitalizeWords(city);
                suggestionsDiv.innerHTML = "";
                suggestionsDiv.style.display = "none";
            });
            suggestionsDiv.appendChild(suggestion);
        });

        suggestionsDiv.style.display = limitedSuggestions.length ? "block" : "none";

        if (limitedSuggestions.length === 1) {
            inputField.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    inputField.value = capitalizeWords(limitedSuggestions[0]);
                    suggestionsDiv.innerHTML = "";
                    suggestionsDiv.style.display = "none";
                    event.preventDefault();
                }
            });
        }
    } else {
        suggestionsDiv.style.display = "none";
    }
});