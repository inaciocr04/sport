

document.addEventListener('DOMContentLoaded', function (){
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
})



