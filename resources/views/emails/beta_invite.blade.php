<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 10px;
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .content {
            padding: 20px 0;
        }

        .code-box {
            background: #f4f4f4;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            margin: 20px 0;
        }

        .code {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #2d3748;
        }

        .button-container {
            text-align: center;
            margin: 30px 0;
        }

        .button {
            background-color: #4a5568;
            color: white !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>FestConnection: Beta</h1>
        </div>
        <div class="content">
            <p>Welcome!</p>
            <p>
                You've been invited to join the very first version of FestConnection Beta!
                We're excited for you to join us. Welcome to the new social platform for
                the music festival community!
            </p>
            <div class="code-box">
                <p>Your invite code:</p>
                <div class="code">{{ $code }}</div>
            </div>
            <p>You can use this code to complete your registration by clicking the button below:</p>
            <div class="button-container">
                <a href="{{ $url }}" class="button">Register Now</a>
            </div>
            <p>Alternatively, copy and paste this link into your browser:</p>
            <p><a href="{{ $url }}">{{ $url }}</a></p>
        </div>
        <div class="footer">
            <p>If you didn't request this invite, you can safely ignore this email.</p>
            <p>&copy; {{ date('Y') }} FestConnection. All rights reserved.</p>
        </div>
    </div>
</body>

</html>