import Notyf from 'notyf';
import 'notyf/notyf.min.css';

const notyf = new Notyf();

document.addEventListener('DOMContentLoaded', function() {
    const addToCartBtn = document.getElementById('addToCartBtn');

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function(event) {
            event.preventDefault();

            fetch('/add-to-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}),
            })
                .then(response => response.json())
                .then(data => {
                    notyf.success(data.message); // Afficher la notification lorsque l'ajout au panier est réussi
                })
                .catch(error => {
                    console.error('Erreur lors de l\'ajout au panier :', error);
                });
        });
    }
});


