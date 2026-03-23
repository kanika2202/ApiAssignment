<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <form method="POST" action="/logins">
        @csrf
        Name:<input type="text" name="name"><br><br>
        Password:<input type="text"name="password"><br><br>
        <input type="submit" value="submit">
    </form>
</body>
</html>