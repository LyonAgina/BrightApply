document.addEventListener('DOMContentLoaded', function() {
    // Navigation functionality
    const navLinks = document.querySelectorAll('.admin-nav li a');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            navLinks.forEach(navLink => {
                navLink.parentElement.classList.remove('active');
            });
            
            // Add active class to clicked link
            this.parentElement.classList.add('active');
            
            // Get the target section ID
            const targetId = this.getAttribute('href').substring(1);
            
            // Hide all sections
            document.querySelectorAll('section[id$="-content"]').forEach(section => {
                section.style.display = 'none';
            });
            
            // Show the target section
            document.getElementById($,{targetId}-content).style.display = 'block';
            
            // Update the section title
            document.getElementById('section-title').textContent = this.textContent.trim();
        });
    });
    
    // Scholarship form toggle
    const addScholarshipBtn = document.getElementById('add-scholarship-btn');
    const scholarshipForm = document.getElementById('scholarship-form');
    const cancelScholarship = document.getElementById('cancel-scholarship');
    
    if (addScholarshipBtn && scholarshipForm) {
        addScholarshipBtn.addEventListener('click', function() {
            scholarshipForm.style.display = 'block';
            this.style.display = 'none';
        });
        
        cancelScholarship.addEventListener('click', function() {
            scholarshipForm.style.display = 'none';
            addScholarshipBtn.style.display = 'flex';
        });
    }
    
    // Form submission handling
    const newScholarshipForm = document.getElementById('new-scholarship-form');
    
    if (newScholarshipForm) {
        newScholarshipForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Here you would typically send the form data to the server
            // For demonstration, we'll just show an alert
            alert('Scholarship created successfully!');
            
            // Reset form and hide it
            this.reset();
            scholarshipForm.style.display = 'none';
            addScholarshipBtn.style.display = 'flex';
        });
    }
    
    // Post management actions
    const postActions = document.querySelectorAll('.post-actions .action-btn');
    
    postActions.forEach(button => {
        button.addEventListener('click', function() {
            const action = this.classList.contains('approve') ? 'approved' : 
                          this.classList.contains('edit') ? 'edited' :
                          this.classList.contains('delete') ? 'deleted' : 
                          'warned user about';
            
            const postItem = this.closest('.post-item');
            const postTitle = postItem.querySelector('h4').textContent;
            
            alert(`Post "${postTitle}" has been ${action}.`);

            
            if (this.classList.contains('delete')) {
                postItem.remove();
            }
        });
    });
    
    // Initialize the dashboard view
    document.querySelector('.admin-nav li.active a').click();
});