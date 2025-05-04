<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSAS</title>
    <link rel="stylesheet" href="../../../assets/css/admin_login.css">
</head>

<body class="admin-body">
    <main class="public-main">
        <div class="login-container">
            <section class="login-header">
                <img src="../../../assets/img/logo.png">
                <div>
                    <p style="font-size: 2rem;">Cavite State University</p>
                    <p style="font-size: 2.6rem;"><b>SILANG CAMPUS</b></p>
                    <p style="font-size: 1.7rem;">Truth | Excellence | Service</p>
                </div>
            </section>

            <section class="login-title">
                <p>OSAS SYSTEM</p>
            </section>

            <div class="tab-buttons">
                <button id="loginTab" class="active" onclick="showForm('login')">Login</button>
                <button id="signupTab" onclick="showForm('signup')">Sign Up</button>
            </div>

            <section id="loginForm" class="login-form form-section active">
                <form action="/admin/login" method="post">
                    <label for="email">Email:</label>
                    <input class="admin-input " type="email" name="login-email" required>

                    <label for="password">Password:</label>
                    <input class="admin-input " type="password" name="login-password" required>

                    <button type="submit" class="primary-button">Log In</button>
                </form>
            </section>

            <section id="signupForm" class="signup-form form-section">
                <form action="/admin/login" method="post">
                    <label for="signup-email">Email:</label>
                    <input class="admin-input " type="email" name="signup-email" required>

                    <label for="signup-password">Password:</label>
                    <input class="admin-input " type="password" name="signup-password" required>

                    <label for="signup-confirm">Confirm Password:</label>
                    <input class="admin-input " type="password" name="signup-confirm-password" required>

                    <button type="submit" class="primary-button">Sign Up</button>
                </form>
            </section>
        </div>
    </main>

    <script>
        function showForm(formName) {
            const loginForm = document.getElementById('loginForm');
            const signupForm = document.getElementById('signupForm');
            const loginTab = document.getElementById('loginTab');
            const signupTab = document.getElementById('signupTab');

            if (formName === 'login') {
                loginForm.classList.add('active');
                signupForm.classList.remove('active');
                loginTab.classList.add('active');
                signupTab.classList.remove('active');
            } else {
                loginForm.classList.remove('active');
                signupForm.classList.add('active');
                loginTab.classList.remove('active');
                signupTab.classList.add('active');
            }
        }
    </script>
</body>

</html>