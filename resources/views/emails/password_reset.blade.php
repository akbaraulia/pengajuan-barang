<!DOCTYPE html>
<html>

<head>
    <title>Reset Kata Sandi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .email-content {
            margin-bottom: 20px;
        }

        .email-footer {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Reset Kata Sandi</h1>
        </div>
        <div class="email-content">
            <p>Anda telah meminta untuk mereset kata sandi Anda. Silakan klik tautan di bawah ini untuk mereset kata
                sandi Anda:</p>
            <p><a href="{{ $resetLink }}">Reset Kata Sandi</a></p>
        </div>
        <div class="email-footer">
            <p>Jika Anda tidak meminta reset kata sandi, silakan abaikan email ini.</p>
            <p>Jika Anda tidak melihat email ini di kotak masuk Anda, silakan periksa folder spam Anda.</p>
        </div>
    </div>
</body>

</html>