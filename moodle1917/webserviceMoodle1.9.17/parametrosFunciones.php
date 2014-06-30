<?php
//function

function iniciarTiempo() {
	list($mseg, $seg) = explode(" ", microtime());
	return ((float) $mseg+(float) $seg);
}
function funcionParametros() {
	$parametros['CERTIFICADO']   = 'V<_-,Jm!H8.ydF,by3OI7`@>R]%9l9+2394005695';
	$parametros['iniciarTiempo'] = iniciarTiempo();
	// ////////////////////       CATEGORIAS       //////////////////////
	/******************************************************************/
	/*                 modulocategoriasRegistrarCategoria             */
	/******************************************************************/
	$parametros['funcion']     = "modulocategoriasRegistrarCategoria";
	$parametros['name']        = "Año áé:".date("Y-m-d H:i:s");
	$parametros['description'] = "Descripcion".time();
	$parametros['parent']      = 77;
	$parametros['theme']       = "standardblue";

	/******************************************************************/
	/*                         Obtener Categoria                      */
	/******************************************************************/
	//$parametros['id'] = 1;
	//echo "<pre>";
	return $parametros;
}//funcionParametros

// esta es una funcion general para no estar agregando migagas entreel codigo
$parametros = funcionParametros();
//imprimirSalida($parametros);

?>
