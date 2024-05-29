let currentIndex = 0;

function moveCarousel(direction) {
    const carousel = document.querySelector('.carousel-images');
    const images = document.querySelectorAll('.carousel-images img');
    const totalImages = images.length;
    
    currentIndex = (currentIndex + direction + totalImages) % totalImages;
    
    const translateX = -currentIndex * 100;
    carousel.style.transform = `translateX(${translateX}%)`;
}
