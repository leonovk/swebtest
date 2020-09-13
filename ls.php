<?php
include 'db.php';
mysqli_set_charset($con, 'utf8');
$vi = $_COOKIE['logc'];
$smska = mysqli_query($con, "SELECT * FROM `sms` WHERE `pol` = '$vi' ORDER BY `sms`.`id` DESC");

//Отправка сообщений
if (isset($_POST['otpr'])) {
  $otpravitel = $_COOKIE['logc'];
  $poluchatel = $_POST['loginp'];
  $text_s = $_POST['sms'];
  if ($otpravitel == $poluchatel) {
    echo "НЕЛЬЗЯ ОТПРАВИТЬ СООБЩЕНИЕ САМОМУ СЕБЕ";
  } else {
    $otpravka = mysqli_query($con, "INSERT INTO `bdeshka`.`sms` (`id`, `otpr`, `pol`, `text`) VALUES (NULL, '$otpravitel', '$poluchatel', '$text_s')");
    echo "СООБЩЕНИЕ ОТПРАВЛЕНО";
  }
}





?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Сообщения</title>
  <link rel="stylesheet" type="text/css" href="style/ls.css">
</head>
<body>
<div class="panel">
<div class="otpr">
  <center><h2>Отправить сообщение</h2></center>
  <center>
  <form action="ls.php" method="post">
    <input type="text" name="loginp" placeholder="Login получателя"><br>
    <input type="text" name="sms" placeholder="Сообщение"><br>
    <input type="submit" name="otpr" value="Отправить">
  </form>
  <form action="lk.php">
    <input type="submit" value="Вернуться">
  </form>
</center>
</div>
<div class="soob">
  <center><h2>Ваши сообщения</h2></center>
  <?php
  while ( ($sms = mysqli_fetch_assoc($smska)) ) {
  	echo "<p>" . $sms['text'] . "<br>" . "От => " . $sms['otpr'] . "</p>";

  }
  ?>
</div>
</div>
</body>
