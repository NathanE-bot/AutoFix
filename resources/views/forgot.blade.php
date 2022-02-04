<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Email Template</title>
</head>
<body style="font-family: 'Nunito', 'Helvetica Neue', 'Helvetica' ,'sans-serif'">
    <div style="margin: auto; padding: 40px 50px; width: 40%; border: 1px solid #e4e5e7; border-radius: 6px">
      <h2 style="font-weight: 400;">Hello {{$tokenForURL[0]->fullName}},</h2>
      <p style="margin-top: 8px;">Your password can be reset by clicking the button below. If you did not request a new password, please ignore this email.</p>
      
      <div style="text-align: center; margin: 12% 0 5% 0">
        <a 
            style="background-color: #21a17b; color: #ffffff; padding: 12px 16px; border-radius: 4px; cursor: pointer; text-decoration:none;"
            onMouseOver="this.style.background='#25b68b'"
            onMouseOut="this.style.background='#21a17b'"
            href="http://localhost:8080/session/resetpassword/{{$tokenForURL[0]->token}}" class="button">Reset Password</a>
      </div>
    </div>
</body>
</html>