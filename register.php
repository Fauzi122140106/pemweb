<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        .alert {
            display: none;
        }
    </style>
</head>
<body class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Register Here</h2>

            <div id="alertBox" class="alert" role="alert"></div>

            <form id="registerForm" action="server.php?action=signup" method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="John Doe">
                    <label for="fullname">Full Name</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="johndoe">
                    <label for="username">Username</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com">
                    <label for="email">Email</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
                    <label for="confirmPassword">Confirm Password</label>
                </div>

                <div class="mb-3">
                    <input type="checkbox" class="form-check-input" id="terms" name="terms">
                    <label for="terms" class="form-check-label">I agree to the terms and conditions</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            </form>

            <p class="text-center mt-3">
                Already have an account? <a href="login.php">Log In</a>
            </p>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function (event) {
            let isValid = true;
            const alertBox = document.getElementById('alertBox');
            alertBox.style.display = 'none';

            const fullname = document.getElementById('fullname').value.trim();
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirmPassword').value.trim();
            const terms = document.getElementById('terms').checked;

            if (!fullname || !username || !email || !password || !confirmPassword || !terms) {
                alertBox.style.display = 'block';
                alertBox.className = 'alert alert-danger';
                alertBox.textContent = 'All fields are required, and terms must be accepted.';
                isValid = false;
            } else if (password !== confirmPassword) {
                alertBox.style.display = 'block';
                alertBox.className = 'alert alert-danger';
                alertBox.textContent = 'Passwords do not match.';
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>