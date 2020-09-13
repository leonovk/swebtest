<?php

if (isset($_POST['per'])) {
  $v_t = $_POST['text'];
  $sv_t = mb_strtolower($v_t);
  $zam = array("пошли", "гулять", "привет");
  $na_zam = array("го", "ебланить", "здарово епта");
  $alg_zameni = str_replace($zam, $na_zam, $sv_t);
  echo "$alg_zameni";

}

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>RET</title>
   </head>
   <body>
     <form action="rts" method="post">
       <input type="text" name="text" placeholder="text">
       <input type="submit" name="per" value="but">
     </form>
   </body>
 </html>
