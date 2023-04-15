<html lang='en'>

<head>
    <meta charset='UTF-8' />
    <meta name='viewport'
        content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0' />
    <meta http-equiv='X-UA-Compatible' content='ie=edge' />
    <title>Automatic Registration</title>
</head>
    <link href='https://fonts.googleapis.com/css?family=Nunito Sans' rel='stylesheet'>

<body>
    <style>
        body {
            background: #FAFAFA;
            font-family: inherit;
            font-weight: 400;
            font-size: 14px;
            color: #262626;
        }

        p {
            font-weight: 400;
            font-size: 14px;
            color: #262626;
        }

        .wrapper {
            width:600px;
            margin: 0 auto;
            padding: 50px;
        }

        .header {
            text-align: center;
        }

        .section {
            background-color: #ffffff;
            width:550px;
            margin: 0px auto;
            padding: 25px;
        }

        span {
            color: #FF7000
        }

        .footer {
            text-align: center;
            font-weight: 400;
            font-size: 12px;
            line-height: 20px;
            margin-top: 20px;
        }
    </style>
    ​
    <div class='wrapper'>
        <div class="header"><img src="" width="200" height="100"
                alt="LOGO"> </div>
        <div class="section">
            <p>
                Hi
                <b>{{$user->name}}</b>,
                <br />
            <p>Your account in AEIRC has been created.</p>
            <p>Please  use this password <span>{{ $user->remember_token }}</span>
                {{-- <span><a style="cursor: pointer;" href="{{uiBaseUrl}}/auth/reset-verification/{{id}}">this link</a></span>  --}}
                to login. 
                {{-- se <span>{{otp}}</span> code. --}}
            </p>
            <i>If you think that you shouldn't have received this email, you can safely ignore it.</i>
            </p>
            <p>Thank You ! <br /><b>AEIRC</b> </p>
        </div>
        <div class="footer">
        <p>© AEIRC . All rights reserved. </p>
        <p>If you have any questions please contact us 
            {{-- <a href="mailto:{{ company_email }}">{{ company_email }}</a>  --}}
        </p>

        </div>
    </div>
</body>

</html>