<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Notification Transaction</title>
</head>

<body>
    <p>{{$content}}</p>
    <br>
    <h5>Sisa saldo Anda: Rp{{number_format($balance, 0, ",", '.')}}</h5>
</body>

</html>
