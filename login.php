<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bright Apply</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h1>Welcome Back</h1>
            <p class="auth-subtitle">Login to Bright Apply</p>
            
            <?php if (isset($_GET['error'])): ?>
                <div style="color: red; margin-bottom: 15px; text-align: center;">
                    <?php echo ($_GET['error'] == 'invalid') ? 'Invalid email or password' : 'Login required'; ?>
                </div>
            <?php endif; ?>
            
            <form class="auth-form" action="process_login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="auth-btn">Login</button>
                
                <div class="auth-divider">
                    <span>or</span>
                </div>
                
                <p class="auth-switch">Don't have an account? <a href="register.php">Sign up</a></p>
            </form>
        </div>
    </div>
</body>
</html>