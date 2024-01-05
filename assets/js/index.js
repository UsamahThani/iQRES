const sideMenu = document.querySelector('aside');
const menuBtn = document.getElementById('menu-btn');
const closeBtn = document.getElementById('close-btn');

const darkMode = document.querySelector('.dark-mode');
const logoImg = document.getElementById('logo-img');

menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
});

closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
});

darkMode.addEventListener('click', () => {
    // Toggle dark mode classes
    document.body.classList.toggle('dark-mode-variables');
    
    // Toggle active class for the spans
    darkMode.querySelector('span:nth-child(1)').classList.toggle('active');
    darkMode.querySelector('span:nth-child(2)').classList.toggle('active');
    
    // Toggle logo image source based on dark mode state
    if (document.body.classList.contains('dark-mode-variables')) {
        logoImg.src = 'https://i.ibb.co/TkRgsZR/iqreslogowhite.png';
    } else {
        logoImg.src = 'https://i.ibb.co/X38FYsM/iqreslogoblack.png';
    }

    // Save user's dark mode preference to localStorage
    const isDarkMode = document.body.classList.contains('dark-mode-variables');
    localStorage.setItem('darkMode', isDarkMode);
});

// Load user's dark mode preference from localStorage (if available)
const isDarkMode = localStorage.getItem('darkMode') === 'true';
if (isDarkMode) {
    document.body.classList.add('dark-mode-variables');
    darkMode.querySelector('span:nth-child(1)').classList.remove('active');
    darkMode.querySelector('span:nth-child(2)').classList.add('active'); // Remove active class from dark mode span
    logoImg.src = 'https://i.ibb.co/TkRgsZR/iqreslogowhite.png';
}
