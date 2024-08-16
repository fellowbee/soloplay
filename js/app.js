let currentIndex = 0;
const slides = document.querySelectorAll('.banner-slide');
const indicators = document.querySelectorAll('.indicator');

// Function to show a specific slide
function showSlide(index) {
    currentIndex = index;
    const offset = -index * 100;
    document.querySelector('.banner-wrapper').style.transform = `translateX(${offset}%)`;

    indicators.forEach((indicator, i) => {
        indicator.classList.toggle('active', i === index);
    });
}

// Function to move to the next slide
function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
}

// Function to move to the previous slide
function previousSlide() {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(currentIndex);
}

// Function to set the current slide based on indicator click
function currentSlide(index) {
    showSlide(index - 1);
}


// Auto-slide functionality for banner
setInterval(nextSlide, 5000);

document.addEventListener('DOMContentLoaded', () => {
    showSlide(currentIndex);

    // Swipe functionality for banner
    let startX = 0;
    let endX = 0;

    document.querySelector('.banner-wrapper').addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
    });

    document.querySelector('.banner-wrapper').addEventListener('touchmove', (e) => {
        endX = e.touches[0].clientX;
    });

    document.querySelector('.banner-wrapper').addEventListener('touchend', () => {
        if (startX > endX + 50) {
            nextSlide();
        } else if (startX < endX - 50) {
            previousSlide();
        }
    });

    // Account Icon Pop-up Menu
    const accountIcon = document.querySelector('.account-icon img');
    const logoutMenu = document.querySelector('.logout-menu');

    accountIcon.addEventListener('click', () => {
        logoutMenu.style.display = logoutMenu.style.display === 'block' ? 'none' : 'block';
    });
});

// Function to scroll left in horizontal scroll view
function scrollBack() {
    const container = document.querySelector('.horizontal-scroll-wrapper');
    container.scrollBy({ left: -260, behavior: 'smooth' });
}

// Function to scroll right in horizontal scroll view
function scrollRight() {
    const container = document.querySelector('.horizontal-scroll-wrapper');
    container.scrollBy({ left: 260, behavior: 'smooth' });
}


// Handle page access based on login status
document.addEventListener('DOMContentLoaded', () => {
    fetch('check_login_status.php')
        .then(response => response.json())
        .then(data => {
            if (!data.loggedIn) {
                window.location.href = 'login.php';
            }
        });
});


