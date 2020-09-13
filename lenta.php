<?php
include 'db.php';
$login = $_COOKIE['logc'];
echo "$login" . "<br>";


$baza = mysqli_query($con, "SELECT * FROM `subs` WHERE `ksub` = '$login'");
$posts = mysqli_query($con, "SELECT * FROM `posts` ORDER BY `posts`.`id` DESC");

while ($a = mysqli_fetch_assoc($baza)) {
  $mas[] = $a['nsub'];
}

while ($b = mysqli_fetch_assoc($posts)) {
  if (in_array($b['author'], $mas)) {
    echo $b['id'] . "<br>";
  }
}

 ?>
