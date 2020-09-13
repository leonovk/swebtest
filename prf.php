<?php
include 'db.php';
mysqli_set_charset($con, 'utf8');

if (isset($_POST['srh'])) {
  setcookie("testc", $_POST['loginf'], time()+3600, "/", "", 0);
}

$login_f2 = $_COOKIE['testc'];

if ($_POST['loginf'] != $_COOKIE['testc']) {
  if (empty($_POST['loginf'])) {
    $login_f = $_COOKIE['testc'];
  } else {
    $login_f = $_POST['loginf'];
  }
} else {
  $login_f = $_COOKIE['testc'];
}


$login_v = $_COOKIE['logc'];



$poisk = mysqli_query($con, "SELECT * FROM `users` WHERE `login` = '$login_f'");
if (mysqli_num_rows($poisk) == 1) {
  $vidpoisk = mysqli_fetch_assoc($poisk);
} else {
  echo "ТАКОГО ПОЛЬЗОВАТЕЛЯ НЕ СУЩЕСТВУЕТ!!!";
}
$posts_f = mysqli_query($con, "SELECT * FROM `posts` WHERE `author` = '$login_f' ORDER BY `posts`.`id` DESC");

if (isset($_POST['like'])) {
  $plike = mysqli_query($con, "SELECT * FROM `subs` WHERE `ksub` = '$login_v' AND `nsub` = '$login_f'");
  if (mysqli_num_rows($plike) == 0) {
    $dobl = mysqli_query($con, "UPDATE `bdeshka`.`users` SET `subs` = `subs` + 1 WHERE `users`.`login` = '$login_f'");
    $sz = mysqli_query($con, "INSERT INTO `bdeshka`.`subs` (`id`, `ksub`, `nsub`) VALUES (NULL, '$login_v', '$login_f')");
    echo "ПОДПИСКА ОФОРМЛЕНА!!!";
  } else {
    echo "ВЫ УЖЕ И ТАК ПОДПИСАНЫ";
  }
}



?>


<!DOCTYPE html>
<html>
<head>
  <title><?php echo $vidpoisk['name']; ?></title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style/prf.css">
</head>
<body>
<div class="profil">
<center><h2><?php echo $vidpoisk['name']; ?></h2></center>
<?php
  $query = $con->query("SELECT * FROM ava WHERE `login` = '$login_f'");
  while($row = $query->fetch_assoc()){
    $show_img = base64_encode($row['img']);?>
    <center><img src="data:image/jpeg;base64, <?=$show_img ?>" alt="" class="ava"></center>
  <?php } ?>
<p class="inf"><?php echo "О себе: " . $vidpoisk['abt']; ?></p>
<p class="inf"><?php echo "Логин: " . $vidpoisk['login']; ?></p>
<p class="inf"><?php echo "Баллы: " . $vidpoisk['ball']; ?></p>
<p class="inf"><?php echo "Подписчики: " . $vidpoisk['subs']; ?></p>
<form action="prf" method="post">
<center><input type="submit" name="like" value="Подписаться"></center>
</form>
<form action="lk">
<center><input type="submit" value="Вернуться" class="back"></center>
</form>

</div>
<div class="postsf1">
  <center><h2><?php echo "Записи пользователя " . $vidpoisk['login']; ?></h2></center>
  <?php
  while ( ($zapisi_f = mysqli_fetch_assoc($posts_f)) ) {
  	echo "<p>" . $zapisi_f['text'] . "<br>" . "</p>";

  }
  ?>
</div>
</body>
</html>
