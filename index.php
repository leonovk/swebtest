<?php
include 'db.php';
mysqli_set_charset($con, 'utf8');
$login = $_COOKIE['logc'];

if (empty($_COOKIE)) {
	$lenta = "АВТОРИЗИРУЙТЕСЬ!";
} else {
	$lenta = "Ваша персональная лента";
}


$posti = mysqli_query($con, "SELECT * FROM `posts` ORDER BY `posts`.`id` DESC");
$baza = mysqli_query($con, "SELECT * FROM `subs` WHERE `ksub` = '$login'");

while ($a = mysqli_fetch_assoc($baza)) {
  $mas[] = $a['nsub'];
}




?>

<!DOCTYPE html>
<html>
<head
	<title></title>
	<title>Главная лента</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="style/gl.css">
</head>
<body>
<div class="posts">
	<form action="log">
		<input type="submit" value="Войти">
	</form>
	<form action="lk">
		<input type="submit" class="prf" value="Профиль">
	</form>
	<center><h1><?php echo $lenta; ?></h1></center>
<?php
while ($b = mysqli_fetch_assoc($posti)) {
  if (in_array($b['author'], $mas)) {
    echo "<p>" . $b['text'] . "<br>" . "Автор => " . $b['author'] . "</p>";
  }
}
?>
</div>
</body>
</html>
