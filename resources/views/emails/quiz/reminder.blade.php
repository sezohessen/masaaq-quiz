<!-- resources/views/emails/quiz_reminder.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quiz Reminder</title>
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
                <p>Just a reminder that you have a quiz starting soon!</p>
                <p><strong>Quiz Name:</strong> {{ $quiz->title }}</p>
                <p><strong>Description:</strong> {{ $quiz->description }}</p>
                <p><strong>Number of Questions:</strong> {{ $quiz->number_of_questions }}</p>
                <p><strong>Score:</strong> {{ $quiz->score }}</p>
                <p><strong>Start Time:</strong> {{ $quiz->start_time?->format('Y-m-d H:i A') }}</p>
                    <a href="{{ route('quiz.begin', ['link' => $link]) }}" class="button">Begin Quiz</a>
            </div>
            <div class="card-footer text-center">
                <p>&copy; {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
