<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login / Sign Up</title>
    <style>
        .scaled-wrapper {
            display: flex;
            justify-content: center;
            align-items: start;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            transform: scale(1.5);
            transform-origin: top center;
        }

        .auth-note {
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
            text-align: center;
            margin-bottom: 20px;
            padding: 15px 20px;
            max-width: 300px;
            border-left: 5px solid var(--primary-hex-yellow);
            border-radius: 6px;
            font-size: 14px;
            line-height: 1.5;
            font-family: 'Gotham';
        }

        .auth-container {
            padding: 30px;
            border-radius: 8px;
            width: 350px;
        }

        .tab-buttons {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .tab-buttons button {
            flex: 1;
            padding: 10px;
            border: none;
            background: none;
            color: white;
            cursor: pointer;
            font-weight: bold;
            border-bottom: 3px solid transparent;
            transition: color 0.3s ease, border-color 0.3s ease;
        }

        .tab-buttons button.active {
            color: var(--primary-hex-yellow);
            border-bottom: 3px solid var(--primary-hex-yellow);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="email"],
        input[type="password"] {
            padding: 10px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            padding: 10px;
            border: none;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }
    </style>
</head>

<body class="public-body">
    <div class="scaled-wrapper">
        <main class="public-main">
            <section class="auth-note">
                <p><strong>Note:</strong> Before you can set up your admission profile, you must log in first.</p>
            </section>

            <div class="auth-container">
                <div class="tab-buttons">
                    <button id="loginTab" class="active" onclick="showForm('login')">Login</button>
                    <button id="signupTab" onclick="showForm('signup')">Sign Up</button>
                </div>

                <div id="loginForm" class="form-section active">
                    <form action="/admission/enrollment" method="post">
                        <input type="email" name="login-email" placeholder="Email" required>
                        <input type="password" name="login-password" placeholder="Password" required>
                        <button type="submit" class="primary-button">Log In</button>
                    </form>
                </div>

                <div id="signupForm" class="form-section">
                    <form action="/admission/enrollment" method="post">
                        <input type="email" name="signup-email" placeholder="Email" required>
                        <input type="password" name="signup-password" placeholder="Password" required>
                        <input type="password" name="signup-confirm-password" placeholder="Confirm Password" required>
                        <button type="submit" class="primary-button">Sign Up</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

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