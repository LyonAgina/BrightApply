document.addEventListener('DOMContentLoaded', function() {
    // 1. Keep your existing code that works
    highlightCurrentPage();
    setupMobileMenu();
    
    // 2. Add these new conditionals to only run on specific pages
    
    // Profile edit page functionality
    if (document.getElementById('avatar-upload')) {
        setupProfileEdit();
    }
    
    
    // Community page functionality
    if (document.getElementById('new-post-toggle')) {
        setupCommunityFeatures();
    }
});

// Keep your existing functions
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
    
    if (mobileMenu && navLinks) {
        mobileMenu.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });
    }
}

const editProfileBtn = document.getElementById('edit-profile');
    
    if (editProfileBtn) {
        editProfileBtn.addEventListener('click', function(e) {
            console.log("Edit profile button clicked!"); // For testing
            window.location.href = 'edit_profile.html';
        });
    }

// Add these new functions for profile editing
function setupProfileEdit() {
    // Avatar upload preview
    const avatarUpload = document.getElementById('avatar-upload');
    avatarUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const avatarPreview = document.getElementById('avatar-preview');
                avatarPreview.style.backgroundImage = `url(${event.target.result})`;
                avatarPreview.textContent = '';
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Profile form submission
    const profileForm = document.getElementById('profile-form');
    profileForm.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Profile updated successfully!');
        window.location.href = 'profile.html';
    });
}

// Add these new functions for community features
function setupCommunityFeatures() {
    // Toggle new post box
    const newPostToggle = document.getElementById('new-post-toggle');
    const postBox = document.getElementById('post-box');
    const cancelPost = document.getElementById('cancel-post');
    
    newPostToggle.addEventListener('click', function() {
        postBox.style.display = postBox.style.display === 'none' ? 'block' : 'none';
    });
    
    cancelPost.addEventListener('click', function() {
        postBox.style.display = 'none';
        document.getElementById('post-content').value = '';
    });
    
    // Submit new post
    const submitPost = document.getElementById('submit-post');
    submitPost.addEventListener('click', function() {
        const postContent = document.getElementById('post-content').value.trim();
        if (postContent) {
            const discussionList = document.getElementById('discussion-list');
            const newPost = createPostElement('You', 'Just now', postContent);
            discussionList.insertBefore(newPost, discussionList.firstChild);
            postBox.style.display = 'none';
            document.getElementById('post-content').value = '';
        }
    });
    
    // Like functionality
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            const likeCountElement = document.querySelector(`.like-count[data-post-id="${postId}"] .count`);
            
            const isLiked = this.classList.contains('liked');
            
            if (isLiked) {
                this.classList.remove('liked');
                this.innerHTML = '<i class="far fa-thumbs-up"></i> Like';
                likeCountElement.textContent = parseInt(likeCountElement.textContent) - 1;
            } else {
                this.classList.add('liked');
                this.innerHTML = '<i class="fas fa-thumbs-up"></i> Liked';
                likeCountElement.textContent = parseInt(likeCountElement.textContent) + 1;
            }
        });
    });
}

function createPostElement(author, time, content) {
    const post = document.createElement('div');
    post.className = 'discussion';
    post.innerHTML = `
        <div class="discussion-author">
            <div class="avatar">${author.charAt(0)}</div>
            <div class="author-info">
                <span class="name">${author}</span>
                <span class="time">${time}</span>
            </div>
        </div>
        <div class="discussion-content">
            <h3>New Post</h3>
            <p>${content}</p>
        </div>
        <div class="discussion-stats">
            <span class="comment-count"><i class="far fa-comment"></i> 0 comments</span>
            <span class="like-count" data-post-id="new"><i class="far fa-thumbs-up"></i> <span class="count">0</span> likes</span>
        </div>
        <div class="discussion-actions">
            <button class="like-btn" data-post-id="new"><i class="far fa-thumbs-up"></i> Like</button>
            <button class="comment-btn"><i class="far fa-comment"></i> Comment</button>
        </div>
    `;
    
    // Add event listener to the new like button
    post.querySelector('.like-btn').addEventListener('click', function() {
        const isLiked = this.classList.contains('liked');
        const likeCountElement = post.querySelector('.like-count .count');
        
        if (isLiked) {
            this.classList.remove('liked');
            this.innerHTML = '<i class="far fa-thumbs-up"></i> Like';
            likeCountElement.textContent = parseInt(likeCountElement.textContent) - 1;
        } else {
            this.classList.add('liked');
            this.innerHTML = '<i class="fas fa-thumbs-up"></i> Liked';
            likeCountElement.textContent = parseInt(likeCountElement.textContent) + 1;
        }
    });
    
    return post;
}