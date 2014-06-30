<?php
exec("ps -fea",$salida_ps);
exec("free",$salida_free);

echo "<pre>"."<br />  <h1>Comando :: free</h1>";
print_r($salida_free);
echo "</pre>";


echo "<pre>"."<br />  <h1>Comando :: ps -fea </h1>";
print_r($salida_ps);
echo "</pre>";



?>