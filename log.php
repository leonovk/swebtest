<?php





?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Авторизация</title>
    <link rel="stylesheet" type="text/css" href="style/log.css">
  </head>
  <body>
    <div class="osnf">
      <form action="lk" method="post">
        <input class="inp" type="text" name="log" placeholder="Login"><br>
        <input class="inp" type="password" name="pass" placeholder="Password"><br>
        <center><input class="knop" type="submit" name="voy" value="Войти"></center>
      </form>
    </div>
    <center><a href="reg.php">Зарегистрироваться</a></center>
    <div class="infa>">
      <p>Кулдаун на одну авторизацию 1 час! Если вы ввели неверный логин или пароль, система просто вас не пропустит.</p>
    </div>
  </body>
</html>
