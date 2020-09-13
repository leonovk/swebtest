<?php
include 'db.php';
mysqli_set_charset($con, 'utf8');
$login = $_COOKIE['logc'];
$baza = mysqli_query($con, "SELECT * FROM `subs` WHERE `ksub` = '$login'");
while ($a = mysqli_fetch_assoc($baza)) {
  $mas[] = $a['nsub'];
}
print_r($mas);


 ?>
