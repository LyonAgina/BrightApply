<?php
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - Scholarship Platform</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <nav>
            <div class="logo">Bright Apply</div>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="scholarships.html">Scholarships</a></li>
                <li><a href="community.html" class="active">Community</a></li>
                <li><a href="login.html" class="login-btn">Login/Signup</a></li>
            </ul>
            <div class="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </nav>
    </header>

    <div class="content-container">
        <aside class="sidebar">
            <ul>
                <li><a href="scholarships.html"><i class="fas fa-award"></i> Scholarships</a></li>
                <li><a href="saved.html"><i class="fas fa-bookmark"></i> Saved</a></li>
                <li class="active"><a href="community.html"><i class="fas fa-users"></i> Community</a></li>
                <li><a href="profile.html"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="community-header">
                <h2>Community Discussions</h2>
                <button class="new-post-btn" id="new-post-toggle"><i class="fas fa-plus"></i> New Post</button>
            </div>

            <div class="post-box" id="post-box" style="display: none;">
                <textarea id="post-content" placeholder="Share something with the community..."></textarea>
                <div class="post-actions">
                    <button class="cancel-btn" id="cancel-post">Cancel</button>
                    <button class="post-btn" id="submit-post">Post</button>
                </div>
            </div>

            <div class="discussion-list" id="discussion-list">
                <!-- Posts will be loaded here dynamically -->
                <div class="discussion">
                    <div class="discussion-author">
                        <div class="avatar">JD</div>
                        <div class="author-info">
                            <span class="name">John Doe</span>
                            <span class="time">2 hours ago</span>
                        </div>
                    </div>
                    <div class="discussion-content">
                        <h3>Tips for writing a winning scholarship essay?</h3>
                        <p>I'm applying for several scholarships and would love to hear any advice on what makes an essay stand out. What has worked for you?</p>
                    </div>
                    <div class="discussion-stats">
                        <span class="comment-count"><i class="far fa-comment"></i> 12 comments</span>
                        <span class="like-count" data-post-id="1"><i class="far fa-thumbs-up"></i> <span class="count">24</span> likes</span>
                    </div>
                    <div class="discussion-actions">
                        <button class="like-btn" data-post-id="1"><i class="far fa-thumbs-up"></i> Like</button>
                        <button class="comment-btn"><i class="far fa-comment"></i> Comment</button>
                    </div>
                </div>
                
                <div class="discussion">
                    <div class="discussion-author">
                        <div class="avatar">AS</div>
                        <div class="author-info">
                            <span class="name">Alice Smith</span>
                            <span class="time">1 day ago</span>
                        </div>
                    </div>
                    <div class="discussion-content">
                        <h3>STEM scholarships with deadlines in July</h3>
                        <p>Here's a list I compiled of STEM-focused scholarships with deadlines coming up next month...</p>
                    </div>
                    <div class="discussion-stats">
                        <span class="comment-count"><i class="far fa-comment"></i> 8 comments</span>
                        <span class="like-count" data-post-id="2"><i class="far fa-thumbs-up"></i> <span class="count">35</span> likes</span>
                    </div>
                    <div class="discussion-actions">
                        <button class="like-btn" data-post-id="2"><i class="far fa-thumbs-up"></i> Like</button>
                        <button class="comment-btn"><i class="far fa-comment"></i> Comment</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
?>