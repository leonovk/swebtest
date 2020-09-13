<?php
include 'db.php';
mysqli_set_charset($con, 'utf8');

$p1 = $_POST['log'];
$p2 = $_POST['pass'];
$p3 = mysqli_query($con, "SELECT * FROM `users` WHERE `login` = '$p1' AND `password` = '$p2'");
if (isset($_POST['voy']) and (mysqli_num_rows($p3) == 1)) {
  setcookie("logc", $_POST['log'], time()+86400, "/", "", 0);
  setcookie("passc", $_POST['pass'], time()+86400, "/", "", 0);
}

if (empty($_COOKIE)) {
  $login = $_POST['log'];
  $password = $_POST['pass'];
} else {
  $login = $_COOKIE['logc'];
  $password = $_COOKIE['passc'];
}
if (empty($_COOKIE) and empty($_POST)) {
  echo "NOOOOOOT";
  header("Location: log");
}

$count = mysqli_query($con, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
if (mysqli_num_rows($count) == 0) {
  echo "Неверный логин или пароль";
  header("Location: bug.php");
} else {
  $akk = mysqli_query($con, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
  $vakk = mysqli_fetch_assoc($akk);
  $avaid = $vakk['login'];
}

if (isset($_POST['per'])) {
  $d_id = $_POST['id'];
  $summab = $_POST['summa'];
  if ($vakk['ball'] >= $summab) {
    $prvka = mysqli_query($con, "SELECT * FROM `users` WHERE `id` = '$d_id'");
    if (mysqli_num_rows($prvka) == 1) {
      $up1 = mysqli_query($con, "UPDATE `bdeshka`.`users` SET `ball` = `ball` + '$summab' WHERE `users`.`id` = '$d_id'");
      $up2 = mysqli_query($con, "UPDATE `bdeshka`.`users` SET `ball` = `ball` - '$summab' WHERE `users`.`login` = '$login'");
      echo "ТРАНЗАКЦИЯ ВЫПОЛНЕНА, <br>";
      echo "!!!При перезагрузки страницы, транзакция повторится!!! <br>";
      echo "НАЖМИТЕ КНОПКУ ОБНОВИТЬ ИНФОРМАЦИЮ <br>";
    } else {
      echo "!!!ОШИБКА!!!";
    }
  } else {
    echo "У вас не хватает баллов!";
  }
}
if (isset($_POST['zapor'])) {
  if ($vakk['ball'] >= 10) {
    $text = $_POST['post'];
    $zapost = mysqli_query($con, "INSERT INTO `bdeshka`.`posts` (`id`, `text`, `author`) VALUES (NULL, '$text', '$login')");
    $up3 = mysqli_query($con, "UPDATE `bdeshka`.`users` SET `ball` = `ball` - 10 WHERE `users`.`login` = '$login'");
    echo "ПОСТ ОПУБЛИКОВАН НА ГЛАВНОЙ ЛЕНТЕ <br>";
    echo "Нажмите кнопку обновить информацию";
  } else {
    echo "У ВАС НЕДОСТАТОЧНО БАЛЛОВ!";
  }
}
$zapisi = mysqli_query($con, "SELECT * FROM `posts` WHERE `author` = '$login' ORDER BY `posts`.`id` DESC");

?>
<!DOCTYPE html>
<html>
<head
<title>
<title><?php echo $vakk['name']; ?></title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/lk.css">
</head>
<body>
  <div class="poisk">
    <center>
  <form action="prf" method="post">
    <input type="text" name="loginf" class="srh1" placeholder="Логин">
    <input type="submit" name="srh" value="Поиск">
  </form>
</center>
</div>
  <div class="lk">
    <center><h2>Личный кабинет</h2></center>
    <center><p class="wh"><?php echo $vakk['name']; ?></p></center>
    <?php
    	$query = $con->query("SELECT * FROM ava WHERE `login` = '$avaid'");
    	while($row = $query->fetch_assoc()){
    		$show_img = base64_encode($row['img']);?>
    		<center><img src="data:image/jpeg;base64, <?=$show_img ?>" alt="" class="ava"></center>
    	<?php } ?>
    <p class="wh"><?php echo "Ваш ID: " . $vakk['id']; ?></p>
    <p class="wh"><?php echo "Ваш логин: " . $vakk['login']; ?></p>
    <p class="wh"><?php echo "Ваши баллы: " . $vakk['ball']; ?></p>
    <p class="wh"><?php echo "Подписчики: " . $vakk['subs']; ?></p>
    <p class="wh"><?php echo "О себе: " . $vakk['abt']; ?></p>
    <center>
    <form action="set" class="men1">
      <center><input type="submit" value="Настройки" class="men1"></center>
    </form>
    <form action="ls" class="men1">
      <center><input type="submit" value="Сообщения" class="men1"></center>
    </form>
  </center>
    <center><p class="wh">Перевести баллы другу:</p></center>
    <form action="lk" method="post" class="perevodi">
    <input type="text" name="id" class="vvod" placeholder="ID"><br>
    <input type="text" name="summa" class="vvod" placeholder="Сумма"><br>
    <center><input type="submit" name="per" value="Перевести"></center>
    </form>
    <center><p class="wh">Отправить сообщение в ленту:</p></center>
    <form action="lk" method="post" class="posti">
    <input type="text" name="post" class="vvod" placeholder="Текст (Стоимость поста 10 баллов)"><br>
    <center><input type="submit" name="zapor" value="Запостить"></center>
    </form>
    <form>
      <center><input type="submit" value="Обновить информацию"></center>
    </form>
    <form action="https://leonov.fun/">
      <center><input type="submit" value="ЛЕНТА"></center>
    </form>
    <center><a href="https://www.instagram.com/leonovkv/">Создатель</a></center>
  </div>
  <div class="zapisi">
    <center><h2>Ваши записи</h2></center>
    <?php
    while ( ($zapisi1 = mysqli_fetch_assoc($zapisi)) ) {
    	echo "<p>" . $zapisi1['text'] . "<br>" . "</p>";

    }
    ?>
  </div>
</body>
</html>
