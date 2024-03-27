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

function hoverImage() {
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

}
document.addEventListener('DOMContentLoaded', function() {
    hoverImage();
});