<?php
$directorioActual = dirname($_SERVER['SCRIPT_FILENAME']); 
exec("ls -ltr $directorioActual/subirArchivos/uploads",$salida_ps);

echo "<pre>"."<br />  <h1>Ver archivos cargados </h1>";
echo "Ruta del direcorio: $directorioActual";
print_r($salida_ps);
echo "</pre>";



?>