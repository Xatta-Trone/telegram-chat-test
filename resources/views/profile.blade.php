<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{auth()->user()->name}}</title>
</head>

<body>

    Name:: {{ auth()->user()->name}}

    <hr>

    Telegram user id:: {{ auth()->user()->t_user_id}}

    <hr>

    Telegram chat id:: {{ auth()->user()->t_chat_id}}

    <hr>

    <script async src="https://telegram.org/js/telegram-widget.js?15" data-telegram-login="xattabot" data-size="large"
        data-auth-url="/tbot" data-request-access="write"></script>





</body>

</html>
