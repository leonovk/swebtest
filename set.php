<?php
include 'db.php';

$ids = $_COOKIE['logc'];
$ids2 = mysqli_query($con, "SELECT * FROM `users` WHERE `login` = '$ids'");
$vakk2 = mysqli_fetch_assoc($ids2);
$id = $vakk2['id'];

if (empty($_COOKIE)) {
  header("Location: lk.php");
}
if (isset($_POST['save'])) {
  $st_u = $_POST['about'];
  $status = mysqli_query($con, "UPDATE `bdeshka`.`users` SET `abt` = '$st_u' WHERE `users`.`id` = '$id'");
  echo "ВАШ СТАТУС ОБНОВЛЕН:" . " " . "$st_u";
}

if (isset($_POST['setname'])) {
  $new_name = $_POST['name1'];
  $set_name = mysqli_query($con, "UPDATE `bdeshka`.`users` SET `name` = '$new_name' WHERE `users`.`id` = '$id'");
  echo "ВАШЕ ИМЯ ИЗМЕНЕННО";
}

if (isset($_POST['setlog'])) {
  $new_log = $_POST['log1'];
  $pr_log = mysqli_query($con, "SELECT * FROM `users` WHERE `login` = '$new_log'");
  if (mysqli_num_rows($pr_log) == 0) {
    $set_log = mysqli_query($con, "UPDATE `bdeshka`.`users` SET `login` = '$new_log' WHERE `users`.`id` = '$id'");
  } else {
    echo "ОШИБКА, ТАКОЙ ЛОГИН УЖЕ ЗАНЯТ";
  }
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>НАСТРОЙКИ</title>
<link rel="stylesheet" type="text/css" href="style/set.css">
</head>

<body>
  <div class="main">
  <p>Информация о себе:</p>
  <form action="set" method="post">
    <input type="text" name="name1" placeholder="Имя:<?php echo $vakk2['name']; ?>">
    <input type="submit" name="setname" value="Изменить">
  </form>
  <p>Изменить логин</p>
  <form action="set" method="post">
    <input type="text" name="log1" placeholder="<?php echo $vakk2['login']; ?>">
    <input type="submit" name="setlog" value="Изменить">
  </form>
  <p>Текущий статус: <?php echo $vakk2['abt']; ?></p>
  <form action="set" method="post">
    <input type="text" name="about" placeholder="О себе">
    <input type="submit" name="save" value="Сохранить">
  </form>
<form action="set.php" method="post" enctype="multipart/form-data">
<p>Загрузить аватарку</p>
<input type="file" name="img_upload"><input type="submit" name="upload" value="Загрузить">
<?php
$proverka = mysqli_query($con, "SELECT * FROM `ava` WHERE `login` = '$ids'");
  if(isset($_POST['upload']) and mysqli_num_rows($proverka) == 1){
  	$img_type = substr($_FILES['img_upload']['type'], 0, 5);
  	$img_size = 2*1024*1024;
  	if(!empty($_FILES['img_upload']['tmp_name']) and $img_type === 'image' and $_FILES['img_upload']['size'] <= $img_size){
  	$img = addslashes(file_get_contents($_FILES['img_upload']['tmp_name']));
    $dobava = mysqli_query($con, "UPDATE `bdeshka`.`ava` SET `img` = '$img' WHERE `login` = '$ids'");
  	}
  }

if (isset($_POST['upload']) and mysqli_num_rows($proverka) == 0) {
  echo "BUG";
  $img_type = substr($_FILES['img_upload']['type'], 0, 5);
  $img_size = 2*1024*1024;
  if(!empty($_FILES['img_upload']['tmp_name']) and $img_type === 'image' and $_FILES['img_upload']['size'] <= $img_size){
  $img = addslashes(file_get_contents($_FILES['img_upload']['tmp_name']));
  $con->query("INSERT INTO `bdeshka`.`ava` (`id`, `login`, `img`) VALUES (NULL, '$ids', '$img')");
  }
}

?>


</form>
<p>Ваша аватарка:</p>
<?php

	$query = $con->query("SELECT * FROM ava WHERE `login` = '$ids'");
	while($row = $query->fetch_assoc()){
		$show_img = base64_encode($row['img']);?>
		<img src="data:image/jpeg;base64, <?=$show_img ?>" alt="" class="ava">
	<?php } ?>

  <form action="lk">
    <input type="submit" value="Вернуться в свой профиль">
  </form>
</div>
</body>
</html>
