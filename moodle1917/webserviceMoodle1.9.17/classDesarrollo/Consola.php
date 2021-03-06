<?php
/* - - - - - - - - - - - - - - - - - - - - -
 Titulo : Debugeador de procesos para PHP
 Autor : Gustavo Ramirez Rugerio
 URL :
 Ultima modificación : 15 de mayo 2014
 Descripción : Esta clase permite validar los procesos de nuestras operaciones ejecutadas del ladao del servidor
- - - - - - - - - - - - - - - - - - - - - */
class Consola {
	function limpiar($limpiarSalida = true, $debugger = "salida") {
		if ($limpiarSalida && $debugger) {
			$archivo = getcwd()."/debugger/".$debugger.".txt";
			$salida = fopen($archivo, "w");
			return fwrite($salida, '');
		}
	}
	// function limpiar
	function registrar($parametro, $debugger = "salida") {
		$archivo = getcwd()."/debugger/".$debugger.".txt";
		$f = fopen($archivo, "a+");
		$cad = print_r($parametro, true);
		$cad .= "\n\n";
		return fwrite($f, $cad);
	}
	//function registrar

}
// class Consola
/*
$parametro = "Holaaaa22";
$archivo   = "salida2";
$consolaLimpiar = Consola::limpiar(true, $archivo);
//$consolaRegistrar = Consola::registrar($para, $archivo);
print_r($consolaLimpiar);
*/
