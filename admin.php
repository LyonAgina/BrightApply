<?php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bright Apply</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <h1>Bright Apply</h1>
                <p>Admin Dashboard</p>
            </div>
            
            <nav class="admin-nav">
                <ul>
                    <li class="active"><a href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="#scholarships"><i class="fas fa-award"></i> Scholarships</a></li>
                    <li><a href="#posts"><i class="fas fa-comments"></i> Community Posts</a></li>
                    <li><a href="#users"><i class="fas fa-users"></i> User Management</a></li>
                    <li><a href="#settings"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </nav>
            
            <div class="admin-footer">
                <div class="admin-profile">
                    <div class="avatar">AD</div>
                    <div class="profile-info">
                        <span class="name">Admin User</span>
                        <span class="role">Super Admin</span>
                    </div>
                </div>
                <a href="login.html" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </aside>
        
        <!-- Main Content Area -->
        <main class="admin-main">
            <header class="admin-header">
                <h2 id="section-title">Admin Dashboard</h2>
                <div class="admin-actions">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <button><i class="fas fa-search"></i></button>
                    </div>
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </div>
                </div>
            </header>
            
            <!-- Dashboard Overview -->
            <section class="dashboard-overview" id="dashboard-content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Active Scholarships</h3>
                            <p class="count">42</p>
                            <p class="change positive">+5 this week</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Total Users</h3>
                            <p class="count">1,248</p>
                            <p class="change positive">+32 this week</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Community Posts</h3>
                            <p class="count">387</p>
                            <p class="change negative">-12 this week</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Pending Approvals</h3>
                            <p class="count">8</p>
                            <p class="change neutral">No change</p>
                        </div>
                    </div>
                </div>
                
                <div class="recent-activity">
                    <h3>Recent Activity</h3>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="activity-content">
                                <p>New scholarship "STEM Innovation Award" was created</p>
                                <span class="time">2 hours ago</span>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-trash-alt"></i>
                            </div>
                            <div class="activity-content">
                                <p>Deleted inappropriate community post by user123</p>
                                <span class="time">5 hours ago</span>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div class="activity-content">
                                <p>Updated profile information for admin user</p>
                                <span class="time">1 day ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Scholarship Management -->
            <section class="scholarship-management" id="scholarships-content" style="display: none;">
                <div class="section-header">
                    <h3>Scholarship Management</h3>
                    <button class="add-btn" id="add-scholarship-btn">
                        <i class="fas fa-plus"></i> Add New Scholarship
                    </button>
                </div>
                
                <!-- Scholarship Form (Hidden by default) -->
                <div class="scholarship-form" id="scholarship-form" style="display: none;">
                    <h4>Create New Scholarship</h4>
                    <form id="new-scholarship-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="scholarship-name">Scholarship Name</label>
                                <input type="text" id="scholarship-name" required>
                            </div>
                            <div class="form-group">
                                <label for="scholarship-amount">Amount ($)</label>
                                <input type="number" id="scholarship-amount" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="scholarship-deadline">Application Deadline</label>
                                <input type="date" id="scholarship-deadline" required>
                            </div>
                            <div class="form-group">
                                <label for="scholarship-type">Type</label>
                                <select id="scholarship-type" required>
                                    <option value="">Select type</option>
                                    <option value="academic">Academic</option>
                                    <option value="athletic">Athletic</option>
                                    <option value="need-based">Need-based</option>
                                    <option value="minority">Minority</option>
                                    <option value="creative">Creative</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="scholarship-description">Description</label>
                            <textarea id="scholarship-description" rows="4" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="scholarship-eligibility">Eligibility Requirements</label>
                            <textarea id="scholarship-eligibility" rows="4" required></textarea>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="cancel-btn" id="cancel-scholarship">Cancel</button>
                            <button type="submit" class="submit-btn">Create Scholarship</button>
                        </div>
                    </form>
                </div>
                
                <!-- Scholarship List -->
                <div class="scholarship-list">
                    <div class="list-header">
                        <div class="list-filter">
                            <select id="scholarship-filter">
                                <option value="all">All Scholarships</option>
                                <option value="active">Active</option>
                                <option value="expired">Expired</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div class="list-search">
                            <input type="text" placeholder="Search scholarships...">
                            <button><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    
                    <table class="scholarship-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Deadline</th>
                                <th>Type</th>
                                <th>Applications</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>STEM Innovation Award</td>
                                <td>$5,000</td>
                                <td>2025-07-15</td>
                                <td>Academic</td>
                                <td>124</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Creative Arts Scholarship</td>
                                <td>$3,000</td>
                                <td>2025-06-30</td>
                                <td>Creative</td>
                                <td>87</td>
                                <td><span class="status active">Active</span></td>
                                <td>
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>First Generation Scholarship</td>
                                <td>$2,500</td>
                                <td>2025-05-20</td>
                                <td>Need-based</td>
                                <td>56</td>
                                <td><span class="status expired">Expired</span></td>
                                <td>
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            
            <!-- Community Post Management -->
            <section class="post-management" id="posts-content" style="display: none;">
                <div class="section-header">
                    <h3>Community Post Management</h3>
                    <div class="filter-options">
                        <select id="post-filter">
                            <option value="all">All Posts</option>
                            <option value="reported">Reported Posts</option>
                            <option value="recent">Recent Posts</option>
                            <option value="popular">Popular Posts</option>
                        </select>
                    </div>
                </div>
                
                <div class="post-list">
                    <div class="post-item">
                        <div class="post-header">
                            <div class="post-author">
                                <div class="avatar">JD</div>
                                <div class="author-info">
                                    <span class="name">John Doe</span>
                                    <span class="time">Posted 2 days ago</span>
                                </div>
                            </div>
                            <div class="post-stats">
                                <span><i class="fas fa-thumbs-up"></i> 24</span>
                                <span><i class="fas fa-comment"></i> 12</span>
                                <span class="reports"><i class="fas fa-flag"></i> 3 reports</span>
                            </div>
                        </div>
                        <div class="post-content">
                            <h4>Tips for writing a winning scholarship essay?</h4>
                            <p>I'm applying for several scholarships and would love to hear any advice on what makes an essay stand out. What has worked for you?</p>
                        </div>
                        <div class="post-actions">
                            <button class="action-btn approve"><i class="fas fa-check"></i> Approve</button>
                            <button class="action-btn edit"><i class="fas fa-edit"></i> Edit</button>
                            <button class="action-btn delete"><i class="fas fa-trash"></i> Delete</button>
                            <button class="action-btn warn"><i class="fas fa-exclamation-triangle"></i> Warn User</button>
                        </div>
                    </div>
                    
                    <div class="post-item reported">
                        <div class="post-header">
                            <div class="post-author">
                                <div class="avatar">AS</div>
                                <div class="author-info">
                                    <span class="name">Alice Smith</span>
                                    <span class="time">Posted 1 week ago</span>
                                </div>
                            </div>
                            <div class="post-stats">
                                <span><i class="fas fa-thumbs-up"></i> 35</span>
                                <span><i class="fas fa-comment"></i> 8</span>
                                <span class="reports"><i class="fas fa-flag"></i> 7 reports</span>
                            </div>
                        </div>
                        <div class="post-content">
                            <h4>STEM scholarships with deadlines in July</h4>
                            <p>Here's a list I compiled of STEM-focused scholarships with deadlines coming up next month...</p>
                            <div class="report-reason">
                                <strong>Report Reason:</strong> Contains external links to unverified sources
                            </div>
                        </div>
                        <div class="post-actions">
                            <button class="action-btn approve"><i class="fas fa-check"></i> Approve</button>
                            <button class="action-btn edit"><i class="fas fa-edit"></i> Edit</button>
                            <button class="action-btn delete"><i class="fas fa-trash"></i> Delete</button>
                            <button class="action-btn warn"><i class="fas fa-exclamation-triangle"></i> Warn User</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="admin.js"></script>
</body>
</html>
?>