<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step M3: Create Category</title>
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .next-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .next-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Step M3: Create a Category</h1>
    <form action="{{ route('inscription.stepM3.submit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="category_name">Category Name</label>
            <input type="text" name="category_name" id="category_name" placeholder="Enter category name" required>
        </div>
        <button type="submit" class="next-button">Create Category and Complete Registration</button>
    </form>
</body>
</html>