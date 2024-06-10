<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quiz result</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .card {
            border: 1px solid #dee2e6;
            border-radius: .25rem;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 24px;
        }
        .card-body {
            font-size: 16px;
        }
        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Dear {{ $member->name }},</div>
            <div class="card-body">
                <p><strong>Quiz Name:</strong> {{ $quizAttempt?->quiz?->title }}</p>
                <p><strong>Description:</strong> {{ $quizAttempt?->quiz?->description }}</p>
                <p><strong>Number of Questions:</strong> {{ $quizAttempt?->quiz?->number_of_questions }}</p>
                <p class="test-secondary text-sm">
                    Your Score: <span class="font-bold">{{ $quizAttempt->score }} / {{ $quizAttempt->quiz?->score }}</span>
                    <span class="text-sm {{ $quizAttempt->passed ? 'text-success' : 'text-danger' }} font-bold">
                        ({{ $quizAttempt->passed ? 'Passed' : 'Failed' }})
                    </span>
                </p>
                <p>You can view your quiz answeres and score:</p>
                <a href="{{ $link }}" class="button">View Quiz result</a>
            </div>
            <div class="card-footer text-center">
                <p>&copy; {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
