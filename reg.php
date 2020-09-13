<?php
include 'db.php';
mysqli_set_charset($con, 'utf8');
if (isset($_POST['reg1'])) {
  $name = $_POST['name1'];
  $login = $_POST['log1'];
  $password = $_POST['pas1'];
  $passt = $_POST['pas2'];
  if ($password == $passt and $login != '' and $password != '' and preg_match("/[А-Яа-я]/", $login) == false) {
    $logs = mysqli_query($con, "SELECT * FROM `users` WHERE `login` = '$login'");
    if (mysqli_num_rows($logs) == 0) {
      $dobakk = mysqli_query($con, "INSERT INTO `bdeshka`.`users` (`id`, `login`, `password`, `name`, `ball`) VALUES (NULL, '$login', '$password', '$name', '100')");
      echo "ВАША УЧЕТНАЯ ЗАПИСЬ СОЗДАНА, НАЖМИТЕ КНОПКУ АВТОРИЗОВАТЬСЯ";
    } else {
      echo "УЧЕТНАЯ ЗАПИСЬ С ТАКИМ ЛОГИНОМ УЖЕ ЕСТЬ";
    }
  } else {
    echo "OSHIBKA ПРОВЕРЬТЕ ВАШИ ДАННЫЕ И ПОПРОБУЙТЕ СНОВО";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Регистрация</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style/reg.css">
</head>
<body>
    <center><h1>Регистрация</h1></center>
<div class="reg">
<form action="reg.php" method="post">
<input type="text" name="name1" class="inp" placeholder="Полное имя"><br>
<input type="text" name="log1" class="inp" placeholder="Login"><br>
<input type="password" name="pas1" class="inp" placeholder="Пароль"><br>
<input type="password" name="pas2" class="inp" placeholder="Подтвердите пароль"><br>
<center><input type="submit" name="reg1" class="reg2" value="Зарегистрироваться"></center>
</form>
<form action="log.php">
  <center><input type="submit" name="log12" class="reg2" value="Авторизоваться"></center>
</form>
</div>
</body>
</html>
