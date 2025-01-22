<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Step 1</title>
    <style>
        /* Container for the button group */
        .button-group {
            display: flex;
            gap: 10px; /* Space between buttons */
        }

        /* Style for the radio button labels */
        .radio-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f0f0f0; /* Default background color */
            border: 2px solid #ccc; /* Default border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s, border-color 0.3s;
        }

        /* Hide the actual radio button */
        .radio-button input {
            display: none;
        }

        /* Style for the selected radio button */
        .radio-button input:checked + span {
            background-color: #007bff; /* Active background color */
            color: white; /* Active text color */
            border-color: #007bff; /* Active border color */
        }

        /* Style for the span inside the label */
        .radio-button span {
            display: block;
            padding: 5px 10px;
            border-radius: 3px;
        }

        /* Style for the Next button */
        .next-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .next-button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <form action="{{ route('inscription.step1.submit') }}" method="POST">
        @csrf
        <div class="button-group">
            <label class="radio-button">
                <input type="radio" name="role" value="manager" required>
                <span>Manager</span>
            </label>
            <label class="radio-button">
                <input type="radio" name="role" value="subscriber" required>
                <span>Subscriber</span>
            </label>
        </div>
        <div class="mt-3">
            <button type="submit" class="next-button">Next</button>
        </div>
    </form>
</body>
</html>