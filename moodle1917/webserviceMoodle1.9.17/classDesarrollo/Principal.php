<?php
include_once ("Consola.php");
include_once ("Utilerias.php");

class Principal {
	function iniciarFuncion($archivo) {
		ob_start(); //Para evitar que imprima los echo
		$iniciarTiempo = microtime(true);
		$consola = new Consola();
		$consolaLimpiar = Consola::limpiar(false, $archivo);
		return $iniciarTiempo;
	}
	//function iniciar
	function terminarFuncion() {
		$consola = new Consola();
		$tiempoInicial1 = $this->iniciarFuncion();
		$terminarTiempo = microtime(true);
		$timpoEjecucion = $terminarTiempo-$tiempoInicial1;;
		$consolaRegistrar = Consola::registrar("Tiempo de ejecucion:".$timpoEjecucion, $archivo);

		//ob_end_clean();

	}
}
//class
/*
function iniciar($archivo) {
	$consola = new Consola();
	$utilerias = new Utilerias();
	$consolaLimpiar = Consola::limpiar(true, $archivo);
	$utilerias->fechaActual();
}
*/
