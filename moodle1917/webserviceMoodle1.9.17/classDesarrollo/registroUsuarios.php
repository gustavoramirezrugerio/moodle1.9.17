<?php
include_once ("Principal.php");
$archivo = "salida2";
function registrarUsuarios($archivo) {
	Principal::iniciarFuncion($archivo);
	$parametro1 = "parametro1...";
	$parametro2 = "parametro2...";
	$parametro3 = "parametro3...";
	Principal::terminarFuncion($parametro3, $archivo);
	return "NONON";
}

$ejecutar = registrarUsuarios($archivo);
print_r($ejecutar);

?>