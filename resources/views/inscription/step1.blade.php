<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Step 1: Register</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            color: #1e3a8a;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .welcome-message {
            color: #3b82f6;
            text-align: center;
            margin-bottom: 1.5rem;
            font-style: italic;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            color: #1e3a8a;
            margin-bottom: 0.5rem;
        }
        input, select {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            font-size: 1rem;
        }
        button {
            background-color: #1e3a8a;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1e40af;
        }
        .error {
            color: #ef4444;
            margin-top: -0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Step 1: Register</h1>
        <p class="welcome-message">Welcome! Let's get you started on your journey.</p>
        <form id="registrationForm" method="POST" action="{{ route('register.step1') }}">
            @csrf
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div>
                <label for="role">Choose Role</label>
                <select id="role" name="role" required>
                    <option value="subscriber">Subscriber</option>
                    <option value="manager">Manager</option>
                </select>
            </div>

            <button type="button" id="nextButton">Next</button>
        </form>
    </div>

    <script>
        document.getElementById('nextButton').addEventListener('click', function() {
            document.getElementById('registrationForm').submit();
        });
    </script>
</body>
</html>



<div id="step2"></div>

<script>
   document.getElementById('nextButton').addEventListener('click', function () {
    const formData = new FormData(document.getElementById('registrationForm'));

    fetch("{{ route('register.step2') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
    const contentType = response.headers.get("content-type");
    if (!contentType || !contentType.includes("application/json")) {
        throw new Error("Session expirée ou réponse invalide");
    }
    return response.json();
})
// 🔥 ERREUR ICI si la réponse est HTML au lieu de JSON
    .then(data => {
        if (data.error) {
            console.error('Erreur Laravel:', data.error);
            alert('Erreur: ' + data.error);
        } else {
            document.getElementById('step2').innerHTML = data.html;
        }
    })
    .catch(error => console.log('Erreur JS:', error));
});

</script>


