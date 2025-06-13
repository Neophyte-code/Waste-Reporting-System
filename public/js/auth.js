 
//  for responsive header
const navLinks = document.querySelector('.nav-links')

function onToggleMenu(e) {
    e.name = e.name === 'menu' ? 'close' : 'menu'
    navLinks.classList.toggle('top-[9%]')
}

// Get modal elements
const authModal = document.getElementById('authModal');
const signInBtn = document.getElementById('signInBtn');
const signInForm = document.getElementById('signInForm');
const signUpForm = document.getElementById('signUpForm');
const showSignUp = document.getElementById('showSignUp');
const showSignIn = document.getElementById('showSignIn');

// Toggle modal when Sign In button is clicked
signInBtn.addEventListener('click', function() {
    if (authModal.classList.contains('hidden')) {
        // Show modal
        authModal.classList.remove('hidden');
        signInForm.classList.remove('hidden');
        signUpForm.classList.add('hidden');
        localStorage.setItem('modalState', 'visible');
        localStorage.setItem('activeForm', 'signIn');
    } else {
        // Hide modal
        authModal.classList.add('hidden');
        localStorage.setItem('modalState', 'hidden');
    }
});

// Close modal when clicking outside
authModal.addEventListener('click', function(e) {
    if (e.target === authModal) {
        authModal.classList.add('hidden');
        localStorage.setItem('modalState', 'hidden');
    }
});

// Switch to Sign Up form
showSignUp.addEventListener('click', function() {
    signInForm.classList.add('hidden');
    signUpForm.classList.remove('hidden');
    localStorage.setItem('activeForm', 'signUp');
});

// Switch to Sign In form
showSignIn.addEventListener('click', function() {
    signUpForm.classList.add('hidden');
    signInForm.classList.remove('hidden');
    localStorage.setItem('activeForm', 'signIn');
});

// Mobile menu toggle function
function onToggleMenu(icon) {
    const navLinks = document.querySelector('.nav-links');
    if (navLinks.style.top === '0px') {
        navLinks.style.top = '-100%';
        icon.name = 'menu';
    } else {
        navLinks.style.top = '0px';
        icon.name = 'close';
    }
}