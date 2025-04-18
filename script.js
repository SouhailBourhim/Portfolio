// Initialize EmailJS
(function() {
    emailjs.init("hmng7secZuBcjzvSe"); // Replace with your actual public key
})();

// Loading animation
window.addEventListener('load', () => {
    const loader = document.querySelector('.loader-wrapper');
    loader.classList.add('fade-out');
    setTimeout(() => {
        loader.style.display = 'none';
    }, 500);
});

// Mobile navigation toggle
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navLinks.classList.toggle('active');
    document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
});

// Close mobile menu when clicking outside
document.addEventListener('click', (e) => {
    if (!hamburger.contains(e.target) && !navLinks.contains(e.target) && navLinks.classList.contains('active')) {
        hamburger.classList.remove('active');
        navLinks.classList.remove('active');
        document.body.style.overflow = '';
    }
});

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        
        if (targetElement) {
            // Close mobile menu if open
            if (navLinks.classList.contains('active')) {
                hamburger.classList.remove('active');
                navLinks.classList.remove('active');
                document.body.style.overflow = '';
            }

            const headerOffset = 70;
            const elementPosition = targetElement.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Form submission handler with EmailJS
const contactForm = document.getElementById('contactForm');

contactForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading state
    const submitBtn = this.querySelector('.submit-btn');
    const originalBtnText = submitBtn.textContent;
    submitBtn.textContent = 'Sending...';
    submitBtn.disabled = true;
    
    // Get form data
    const formData = {
        name: this.querySelector('#name').value,
        email: this.querySelector('#email').value,
        subject: this.querySelector('#subject').value,
        message: this.querySelector('#message').value
    };
    
    // Send email using EmailJS
    emailjs.send('service_n10v8uk', 'template_8zba449', formData)
        .then(function(response) {
            console.log('SUCCESS!', response.status, response.text);
            
            // Add success message
            const messageDiv = document.createElement('div');
            messageDiv.className = 'success-message';
            messageDiv.textContent = 'Thank you for your message! I will get back to you soon.';
            messageDiv.style.cssText = `
                color: var(--success);
                text-align: center;
                margin-top: 20px;
                padding: 15px;
                border-radius: 10px;
                background: rgba(56, 193, 114, 0.1);
                animation: fadeIn 0.5s ease;
            `;
            
            // Remove any existing message
            const existingMessage = contactForm.querySelector('.success-message, .error-message');
            if (existingMessage) {
                existingMessage.remove();
            }
            
            contactForm.appendChild(messageDiv);
            
            // Reset form
            contactForm.reset();
            contactForm.classList.add('form-success');
            
            // Remove message after delay
            setTimeout(() => {
                messageDiv.remove();
                contactForm.classList.remove('form-success');
            }, 10000);
        })
        .catch(function(error) {
            console.error('FAILED...', error);
            
            // Add error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = 'An error occurred. Please try again later.';
            errorDiv.style.cssText = `
                color: var(--danger);
                text-align: center;
                margin-top: 20px;
                padding: 15px;
                border-radius: 10px;
                background: rgba(227, 52, 47, 0.1);
                animation: fadeIn 0.5s ease;
            `;
            
            // Remove any existing message
            const existingMessage = contactForm.querySelector('.success-message, .error-message');
            if (existingMessage) {
                existingMessage.remove();
            }
            
            contactForm.appendChild(errorDiv);
            
            // Remove message after delay
            setTimeout(() => {
                errorDiv.remove();
            }, 10000);
        })
        .finally(() => {
            // Reset button state
            submitBtn.textContent = originalBtnText;
            submitBtn.disabled = false;
        });
});

// Scroll animations
const header = document.querySelector('header');
const sections = document.querySelectorAll('section');

window.addEventListener('scroll', () => {
    // Header scroll effect
    if (window.scrollY > 100) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
    
    // Section animations
    sections.forEach(section => {
        const sectionTop = section.getBoundingClientRect().top;
        const sectionBottom = section.getBoundingClientRect().bottom;
        
        if (sectionTop < window.innerHeight * 0.75 && sectionBottom > 0) {
            section.classList.add('active');
        }
    });
});

// Initialize sections on load
sections.forEach(section => {
    if (section.getBoundingClientRect().top < window.innerHeight * 0.75) {
        section.classList.add('active');
    }
});

// Add hover effect to project cards
document.querySelectorAll('.project-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-15px)';
    });
    
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0)';
    });
}); 