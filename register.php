<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Parking</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#FFF27B">
    <link rel="apple-touch-icon" href="img/icon-96x96.png">
</head>
<body>
    <div id="main">
        <h2 style="margin-top: 20vh; display: inline-block;">Smart Parking</h2><br>
        <form action="sotpc.php" method="post">
            <input type="text" class="input_login" name="name" placeholder="Name">
            <input type="tel" id="phone" class="input_login" name="phone_no" placeholder="Phone Number" pattern="[789]{1}[0-9]{9}" required>
            <input class="input_login" type="email" name="email" placeholder="E-mail Address" id="email" required>
            <input type="text" class="input_login" name="username" placeholder="Username">
            <input type="password" class="input_login" name="password" placeholder="Password">
            <input type="password" class="input_login" name="c_password" placeholder="Confirm Password">
            <input class="input" style="width: 40%; padding: 0; margin-left: 30%; background-color: #232323; color: white;" type="submit" name="submit" id="submit" value="Done">
        </form>
    </div>
</body>
</html>