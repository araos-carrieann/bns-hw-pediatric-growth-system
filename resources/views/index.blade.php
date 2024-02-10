<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="../assets/css/indexStyle.css">
    <script src="../assets/js/index.js" defer></script>

</head>

<body>
    <header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="#" class="logo">
                <img src="/images/logo.jpg" alt="logo">
            </a>
            <ul class="links">
                <span class="close-btn material-symbols-rounded">close</span>
                <li><a href="#">Home</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Community Project</a></li>
            </ul>
            <button class="login-btn">LOG IN</button>
        </nav>
    </header>


    <div class="blur-bg-overlay"></div>
    <div class="form-popup">
        <span class="close-btn material-symbols-rounded">close</span>
        <div class="form-box login">
            <div class="form-details">
            </div>
            <div class="form-content">
                <h2>LOGIN</h2>
                <form method="POST" action="{{ route('check.login') }}">
                    @csrf <!-- Add CSRF token for Laravel forms -->

                    <div class="input-field">
                        <input type="email" name="email" id="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" id="password" required>
                        <label>Password</label>
                    </div>
                    <a href="#" class="forgot-pass-link">Forgot password?</a>
                    <button type="submit">Log In</button>
                </form>
                @if(session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
                @endif

            </div>
        </div>
    </div>
    </div>


    <div class="title">
        <h1>Pediatric Growth Monitoring And Assessment Information</h1>
    </div>
    <footer class="footer-distributed">

        <div class="footer-left">

            <h3>BHW<span>system</span></h3>

            <p class="footer-links">
                <a href="#" class="link-1">Home</a>

                <a href="#">About</a>

                <a href="#">Contact</a>
            </p>

            <p class="footer-company-name">Barangay health workers © 2024</p>
        </div>

        <div class="footer-center">

            <div>
                <i class="fa fa-map-marker"></i>
                <p><span>PUP</span> Unisan Quezon</span></p>
            </div>

            <div>
                <i class="fa fa-map-marker"></i>
                <p><span>3rd Year</span> Project System</span></p>
            </div>





        </div>

        <div class="footer-right">

            <p class="footer-company-about">
                <span>About our System</span>
                Hndi namin alam ilalagay
            </p>

            <div class="footer-icons">

                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>


            </div>

        </div>

    </footer>
</body>

</html>
<script src="{{url('js/index.js')}}"></script>