<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Sent</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="confirmation-message" style="display:none;">
        {{ $message }}
        @foreach($users as $user)
            <p>{{ $user->name }}</p>
        @endforeach
    </div>

    <script>
        $(document).ready(function() {
            $('#confirmation-message').fadeIn().delay(3000).fadeOut(); // Show message for 3 seconds
        });
    </script>
</body>
</html>
