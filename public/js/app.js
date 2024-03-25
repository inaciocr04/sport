import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css'; // Assurez-vous d'inclure le fichier CSS

const Toastify = window.Toastify;

// Sélectionnez un élément (par exemple, un bouton)
const button = document.getElementById('my-button');

// Ajoutez un gestionnaire d'événement pour le clic sur le bouton
button.addEventListener('click', () => {
    // Affichez une notification avec Toastify
    Toastify({
        text: "Objet ajouté au panier",
        duration: 3000, // Durée de la notification en millisecondes
        gravity: "bottom", // Position de la notification
        backgroundColor: "#4CAF50", // Couleur de fond de la notification
    }).showToast();
});

