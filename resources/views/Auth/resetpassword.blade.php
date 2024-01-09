<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>

<body style="font-family: 'Arial', sans-serif;">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="background-color: #f4f4f4; padding: 20px;">
                <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center" style="padding: 40px;">
                            <h1 style="color: #333;">Password Reset</h1>
                            <p style="color: #555; line-height: 1.6;">You have requested to reset your password. Click the link below to reset it:</p>
                            <p style="color: #555; font-size: 16px;"><a href="YOUR_RESET_LINK" style="color: #3498db; text-decoration: none;">Reset Your Password</a> or use this: {{$password}}</p>
                            <p style="color: #555; line-height: 1.6;">If you did not request a password reset, please ignore this email.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>
