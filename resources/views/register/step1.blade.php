
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            background-color: #f0f4f8;
        }

        .split-container {
            display: flex;
            width: 100%;
            height: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transition: transform 2s ease-in-out;
        }

        .welcome-side, .register-side {
            width: 50%;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            transition: all 0.5s ease;
        }

        .welcome-side {
            background: linear-gradient(135deg,rgb(28, 41, 61), #1e40af, #1e3a8a);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .welcome-side::before,
        .welcome-side::after {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            transition: all 0.8s ease;
        }

        .welcome-side::before {
            top: -25%;
            left: -25%;
        }

        .welcome-side::after {
            bottom: -25%;
            right: -25%;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: #f0f4f8;
        }

        .logo span {
            color:rgb(193, 206, 228);
        }

        .welcome-text {
            font-size: 1.8rem;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        .register-side {
            background: white;
        }

        .register-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .form-title {
            font-size: 2.5rem;
            color:rgb(84, 95, 131);
            margin-bottom: 2rem;
            text-align: center;
            font-weight: 700;
        }

        .register-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .register-form input,
        .register-form select {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .register-form input:focus,
        .register-form select:focus {
            outline: none;
            border-color:rgb(51, 70, 100);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background-color: white;
        }

        .register-form button {
            width: 100%;
            padding: 1rem;
            background-color:rgb(84, 113, 158);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .register-form button:hover {
            background-color: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        @media (max-width: 768px) {
            .split-container {
                flex-direction: column;
            }

            .welcome-side,
            .register-side {
                width: 100%;
            }

            .welcome-side {
                padding: 3rem 1rem;
            }

            .welcome-text {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="split-container" id="splitContainer">
        <div class="welcome-side" id="welcomeSide">
            <h1 class="logo">Tec<span>h</span>orizon</h1>
            <p class="welcome-text" id="welcomeText">
                Welcome to TechHorizon! We're excited to have you join our community. Let's build something amazing together!
            </p>
        </div>

        <div class="register-side" id="registerSide">
            <div class="register-container">
                <h2 class="form-title">Join Us</h2>
                <form class="register-form" method="POST" action="{{ url('/register') }}">
                    @csrf
                    <input type="text" name="name" placeholder="Nom" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required>
                    <select name="role" required>
                        <option value="subscriber">Subscriber</option>
                        <option value="manager">Manager</option>
                    </select>
                    <button type="submit">Commencer l'aventure</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const splitContainer = document.getElementById('splitContainer');
        const welcomeSide = document.getElementById('welcomeSide');
        const registerSide = document.getElementById('registerSide');

        function swapDivs() {
            splitContainer.style.transform = 'rotateY(180deg)';
            welcomeSide.style.transform = 'rotateY(180deg)';
            registerSide.style.transform = 'rotateY(180deg)';
        }

        function resetDivs() {
            splitContainer.style.transform = 'rotateY(0deg)';
            welcomeSide.style.transform = 'rotateY(0deg)';
            registerSide.style.transform = 'rotateY(0deg)';
        }

        welcomeSide.addEventListener('mouseover', swapDivs);
        welcomeSide.addEventListener('mouseout', resetDivs);
    </script>
</body>
</html>
