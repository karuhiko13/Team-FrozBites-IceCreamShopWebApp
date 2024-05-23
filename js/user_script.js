let profile = document.querySelector('.header .flex .profile-detail');
let searchForm = document.querySelector('.header .flex .search-form');
let navbar = document.querySelector('.navbar');

document.querySelector('#user-btn').onclick = () => {
    profile.classList.toggle('active');
    searchForm.classList.remove('active');
}

document.querySelector('#search-btn').onclick = () => {
    searchForm.classList.toggle('active');
    profile.classList.remove('active');
}

document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
}

/*----for slider----*/
const slides = document.querySelectorAll('.slideBox');
let currentSlide = 0;
const autoSlideInterval = 6000; // 6 seconds

function nextSlide() {
    console.log("Next slide clicked"); // Check if function is triggered
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + 1) % slides.length;
    slides[currentSlide].classList.add('active');
}

function prevSlide() {
    console.log("Previous slide clicked"); // Check if function is triggered
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    slides[currentSlide].classList.add('active');
}

// Auto slide function
function autoSlide() {
    console.log("Auto sliding"); // Check if auto slide function is triggered
    nextSlide();
}   

// Start auto sliding
let autoSlideTimer = setInterval(autoSlide, autoSlideInterval);

// Stop auto sliding when interacting with controls
document.querySelectorAll('.controls li').forEach(control => {
    control.addEventListener('click', () => {
        clearInterval(autoSlideTimer); // Stop auto sliding
        autoSlideTimer = setInterval(autoSlide, autoSlideInterval); // Restart auto sliding
    });
});

