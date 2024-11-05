const cityName = "{{ name|e('js') }}";
const latitude = {{ latitude }};
const longitude = {{ longitude }};

const apiKey = "779875b69f9002abced6c51cc13f5502";

async function fetchWeather() {
    const url = `https://api.openweathermap.org/data/2.5/weather?lat=${latitude}&lon=${longitude}&appid=${apiKey}&units=metric&lang=fr`;

    try {
        const response = await fetch(url);
        const weatherData = await response.json();
        console.log("Données météo :", weatherData);

        const weatherContainer = document.getElementById("weather");
        weatherContainer.innerHTML = `
            <div class="weather-summary">
                <h2>Météo actuelle</h2>
                <img src="https://openweathermap.org/img/wn/${weatherData.weather[0].icon}.png" alt="Icone Météo">
                <p><strong>Température :</strong> ${weatherData.main.temp} °C</p>
                <p><strong>Description :</strong> ${weatherData.weather[0].description}</p>
                <p><strong>Vent :</strong> ${weatherData.wind.speed} m/s</p>
                <p><strong>Humidité :</strong> ${weatherData.main.humidity}%</p>
                <button id="showMoreBtn" onclick="toggleDetails()">Afficher plus</button>
            </div>

            <div class="weather-details hidden">
                <h3>Détails</h3>
                <p><strong>Température ressentie :</strong> ${weatherData.main.feels_like} °C</p>
                <p><strong>Température min :</strong> ${weatherData.main.temp_min} °C</p>
                <p><strong>Température max :</strong> ${weatherData.main.temp_max} °C</p>
                <p><strong>Pression :</strong> ${weatherData.main.pressure} hPa</p>
                <p><strong>Visibilité :</strong> ${weatherData.visibility} m</p>
                <p><strong>Pluie :</strong> ${weatherData.rain ? `${weatherData.rain["1h"]} mm/h` : 'Aucune précipitation'}</p>
                <p><strong>Couverture nuageuse :</strong> ${weatherData.clouds.all}%</p>
                <p><strong>Lever du soleil :</strong> ${new Date(weatherData.sys.sunrise * 1000).toLocaleTimeString()}</p>
                <p><strong>Coucher du soleil :</strong> ${new Date(weatherData.sys.sunset * 1000).toLocaleTimeString()}</p>
            </div>
        `;
    } catch (error) {
        console.error("Erreur lors de la récupération des données météo :", error);
        document.getElementById("weather").textContent = "Erreur lors de la récupération des données météo.";
    }
}

function toggleDetails() {
    const details = document.querySelector('.weather-details');
    const showMoreBtn = document.getElementById("showMoreBtn");
    details.classList.toggle('hidden');
    showMoreBtn.textContent = details.classList.contains('hidden') ? "Afficher plus" : "Afficher moins";
}

document.addEventListener("DOMContentLoaded", fetchWeather);

function initMap() {
    const map = L.map('map').setView([latitude, longitude], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([latitude, longitude]).addTo(map)
        .bindPopup(`<b>${cityName}</b><br>Latitude: ${latitude}, Longitude: ${longitude}`)
        .openPopup();
}

document.addEventListener("DOMContentLoaded", initMap);
