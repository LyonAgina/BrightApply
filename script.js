document.addEventListener('DOMContentLoaded', function() {
    // Core functionality that applies to all pages
    highlightCurrentPage();
    setupMobileMenu();
    
    // Only include what you're actually using
    if (document.getElementById('profile-form')) {
        setupProfileEdit();
    }
});

function highlightCurrentPage() {
    const currentPage = window.location.pathname.split('/').pop();
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    
    sidebarLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }
    });
}

function setupMobileMenu() {
    const mobileMenu = document.querySelector('.mobile-menu');
    const navLinks = document.querySelector('.nav-links');
    
    if (!mobileMenu || !navLinks) return;
    
    mobileMenu.addEventListener('click', function() {
        navLinks.classList.toggle('active');
    });
}

function setupProfileEdit() {
    const profileForm = document.getElementById('profile-form');
    if (!profileForm) return;

    profileForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = profileForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        
        fetch('update_profile.php', {
            method: 'POST',
            body: new FormData(profileForm)
        })
        .then(response => {
            if (response.status === 401) {
                window.location.href = 'login.php';
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showToast('Profile updated successfully!', 'success');
            } else {
                showToast(data.message || 'Error updating profile', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to update profile. Please try again.', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    });
}

// Helper function for better notifications
function showToast(message, type = 'info') {
    // Implement your preferred notification system
    console.log(`${type}: ${message}`);
    alert(message); // Temporary - replace with better UI
}