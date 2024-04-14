function resetDropdownScript() {

    const dropdown = document.querySelector('.dropdown');
    const dropdownContent = dropdown.querySelector('.dropdown_content');

    dropdown.addEventListener('mouseenter', () => {
        dropdownContent.style.display = 'block';
    });
    dropdown.addEventListener('mouseleave', () => {
        dropdownContent.style.display = 'none';
    });

    document.addEventListener('click', (event) => {
        if (!dropdown.contains(event.target)) {
            dropdownContent.style.display = 'none';
        }
    });
}
document.addEventListener('DOMContentLoaded', function() {
    resetDropdownScript();
});
function initSwiper() {
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        cssMode: true,
        freeMode: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        mousewheel: true,
        keyboard: true,
    });
}
document.addEventListener('DOMContentLoaded', function() {
    initSwiper();
});
document.addEventListener('DOMContentLoaded', function() {

    const image1 = document.getElementById('image_seul1');
    const image2 = document.getElementById('image_seul2')
    const image3 = document.getElementById('image_seul3')
    const image4 = document.getElementById('image_seul4')

    const imagePetite1 = document.getElementById('image_petite1')
    const imagePetite2 = document.getElementById('image_petite2')
    const imagePetite3 = document.getElementById('image_petite3')
    const imagePetite4 = document.getElementById('image_petite4')

        imagePetite1.addEventListener('mouseenter', () => {
            image1.style.display = "block";
            image2.style.display = "none";
            image3.style.display = "none";
            image4.style.display = "none";
        })

        imagePetite2.addEventListener('mouseenter', () => {
            image1.style.display = "none";
            image2.style.display = "block";
            image3.style.display = "none";
            image4.style.display = "none";
        })
        imagePetite3.addEventListener('mouseenter', () => {
            image1.style.display = "none";
            image2.style.display = "none";
            image3.style.display = "block";
            image4.style.display = "none";
        })
        imagePetite4.addEventListener('mouseenter', () => {
            image1.style.display = "none";
            image2.style.display = "none";
            image3.style.display = "none";
            image4.style.display = "block";
        })

});


document.addEventListener('DOMContentLoaded', function () {
    const taillesTitre = document.querySelector('#tailles');
    const allTailles = document.querySelector('.all_tailles');
    const iconDeroulant = document.querySelector('#icon-deroulant');

    let taillesVisible = false;

    taillesTitre.addEventListener('click', () => {
        if (!taillesVisible) {
            allTailles.classList.remove('none')
            allTailles.style.height = 'auto';
            iconDeroulant.className = 'bi bi-caret-up-fill';
            taillesVisible = true;
        } else {
            allTailles.classList.add('none')
            allTailles.style.height = '0';
            iconDeroulant.className = 'bi bi-caret-down-fill';
            taillesVisible = false;
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const couleursTitre = document.querySelector('#couleurs');
    const allCouleurs = document.querySelector('.all_couleurs');
    const iconDeroulant = document.querySelector('#icon-deroulant2');

    let couleursVisible = false;

    couleursTitre.addEventListener('click', () => {
        if (!couleursVisible) {
            allCouleurs.classList.remove('none')
            allCouleurs.style.height = '0';
            iconDeroulant.className = 'bi bi-caret-up-fill';
            couleursVisible = true;
        } else {
            allCouleurs.classList.add('none');
            allCouleurs.style.height = '0';
            iconDeroulant.className = 'bi bi-caret-down-fill';
            couleursVisible = false;
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const categorieTitre = document.querySelector('#categorie-titre');

    const categoryId = window.location.pathname.split('/categorie/').pop();
    const couleurId = window.location.pathname.split('/baskets/couleur/').pop();

    if (categoryId) {
        const categorieLink = document.querySelector(`.categorie-link[href$="/${categoryId}"]`);
        if (categorieLink) {
            const categoryName = categorieLink.getAttribute('data-category-name');
            categorieTitre.textContent = `${categoryName}`;
        }
    }
    if (couleurId) {
        const couleurLink = document.querySelector(`.couleur-link[href$="/${couleurId}"]`);
        if (couleurLink) {
            const couleurName = couleurLink.getAttribute('data-category-name');
            categorieTitre.textContent = `${couleurName}`;
        }
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const elementsLike = document.querySelectorAll('.Btn-like');

    elementsLike.forEach(btnLike => {
        const coeur = btnLike.querySelector('.bi.bi-heart');
        const compteurLike = btnLike.querySelector('.compteur-like');

        btnLike.addEventListener('mouseenter', () => {
            coeur.classList.add('bi-heart-fill');
            coeur.classList.remove('bi-heart');
            compteurLike.style.color = 'white';
        });

        btnLike.addEventListener('mouseleave', () => {
            coeur.classList.add('bi-heart');
            coeur.classList.remove('bi-heart-fill');
            compteurLike.style.color = 'black';
        });
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const prixTotalElement = document.getElementById('prix-total');
    let prixTotal = 0;
    const prixElements = document.querySelectorAll('.prix');

    prixElements.forEach(prixElement => {
        const prix = parseFloat(prixElement.textContent.replace(' €', ''));
        prixTotal += prix; // Ajouter le prix à la somme totale
    });

    // Mettre à jour le texte de l'élément avec le prix total
    prixTotalElement.textContent = `Prix total: ${prixTotal.toFixed(2)} €`;

    // Sélectionner tous les boutons "plus" et "moins"
    const plusButtons = document.querySelectorAll('.plus');
    const moinsButtons = document.querySelectorAll('.moins');

    // Ajouter un gestionnaire d'événements de clic pour chaque bouton "plus"
    plusButtons.forEach(button => {
        button.addEventListener('click', () => {
            const quantiteElement = button.parentElement.querySelector('.quantite-value');
            let quantite = parseInt(quantiteElement.textContent);
            quantite++;
            quantiteElement.textContent = quantite;

            const prixElement = button.parentElement.parentElement.querySelector('.prix');
            const prixUnitaire = parseFloat(prixElement.textContent.replace(' €', ''));
            prixTotal += prixUnitaire;
            prixTotalElement.textContent = `Prix total: ${prixTotal.toFixed(2)} €`;
        });
    });

    // Ajouter un gestionnaire d'événements de clic pour chaque bouton "moins"
    moinsButtons.forEach(button => {
        button.addEventListener('click', () => {
            const quantiteElement = button.parentElement.querySelector('.quantite-value');
            let quantite = parseInt(quantiteElement.textContent);
            if (quantite > 1) {
                quantite--;
                quantiteElement.textContent = quantite;

                const prixElement = button.parentElement.parentElement.querySelector('.prix');
                const prixUnitaire = parseFloat(prixElement.textContent.replace(' €', ''));
                prixTotal -= prixUnitaire;
                prixTotalElement.textContent = `Prix total: ${prixTotal.toFixed(2)} €`;
            }
        });
    });
});



