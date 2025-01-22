<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 3: Select Interests</title>
    <style>
        .interest-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .interest-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f0f0f0;
            border: 2px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .interest-button input {
            display: none;
        }

        .interest-button input:checked + span {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .interest-button span {
            display: block;
            padding: 5px 10px;
            border-radius: 3px;
        }

        .interest-button:hover {
            background-color: #e0e0e0;
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
    <h1>Step 3: Select Your Interests</h1>
    <form action="{{ route('inscription.step3.submit') }}" method="POST">
        @csrf
        <div class="interest-container">
            @foreach($interests as $interest)
                <label class="interest-button">
                    <input type="checkbox" name="interests[]" value="{{ $interest->id }}">
                    <span>{{ $interest->name }}</span>
                </label>
            @endforeach
        </div>
        <button type="submit" class="next-button">Complete Registration</button>
    </form>
</body>
</html>