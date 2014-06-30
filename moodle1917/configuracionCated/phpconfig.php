<?php
   $nombre_fichero = "../config.php";
   $fichero_url = fopen ($nombre_fichero, "r");
   $texto = "";
   while ($trozo = fgets($fichero_url, 1024))
      $texto .= $trozo."<br />";
   
   print_r($texto);
?>
