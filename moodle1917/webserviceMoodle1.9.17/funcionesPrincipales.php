<?php

function moduloPrincipalImprimirSalidaLog($datosEntrada) {
	logWebservice("::::::::::::::::::::::::SALIDA: ".$datosEntrada["funcion"]."::::::::::::::::::::::::");
	logWebservice($datosEntrada);
}

function moduloPrincipalFuncionesInicio($datosEntrada) {
	moduloPrincipalCodificacionParametros($datosEntrada);
	logWebservice("::::::::::::::::::::::::ENTRADA: ".$datosEntrada["funcion"]."::::::::::::::::::::::::");
	logWebservice($datosEntrada);
	global $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_SERVER_VARS, $MCACHE;
	global $USER, $CFG, $SITE, $COURSE, $db, $THEME;
	ob_start();//Para evitar que imprima los echo
	$CERTIFICADO_MOODLE = $CFG->passwordsaltmain.'+'.'2394005695';
	if ($CERTIFICADO_MOODLE == $datosEntrada['CERTIFICADO']) {
		$verificacionExpiracionCertificado = verificacionExpiracionCertificado($datosEntrada['CERTIFICADO']);
		if (!empty($verificacionExpiracionCertificado)) {
			$salida = $datosEntrada['CERTIFICADO'] = $verificacionExpiracionCertificado;
		} else {
			$datosEntrada['CERTIFICADO'] = "Madre mia este es un problemon en la certificación de los WS";
		}//else
	} else {
		$datosEntrada['CERTIFICADO'] = "No existe certificado";
		return $datosEntrada;
	}//else
	//$datosEntrada = array2obj($datosEntrada);
	return $datosEntrada;
}

function verificacionExpiracionCertificado($datosEntrada) {
	//imprimirSalida($datosEntrada);
	$expiracion = substr($datosEntrada, -10);
	if ($expiracion <= time()) {
		return "Ha expirado su certificado";
	} else {
		return $datosEntrada;
	}
	// TODO aqui podemos enviar correos para inidicar que esta proximo a vencer su certificado
}

function errorRegistro($datosProcesados) {
	//imprimirSalida("function::errorRegistro");
	if ($datosEntrada == "Ha expira su certificado") {
		$datosEntrada['CERTIFICADO'] = $datosProcesados;
		moduloPrincipalImprimirSalidaLog($datosEntrada);
		return $datosEntrada;
	}

	if (empty($datosEntrada['CERTIFICADO'])) {
		$datosEntrada['ERROR'] = "Falta proporcionar información";
		moduloPrincipalImprimirSalidaLog($datosEntrada);
		return $datosEntrada;
	}
}

function get_micro_time() {
	list($mseg, $seg) = explode(" ", microtime());
	return ((float) $mseg+(float) $seg);
}

function moduloPrincipalFuncionesCierre($datosProcesados, $identificadorMoodle) {
	ob_end_clean();
	$tiempoinicial                                  = $datosProcesados["iniciarTiempo"];
	$datosProcesados                                = "";
	$datosProcesados["identificadorMoodle"]         = $identificadorMoodle;
	$datosProcesados["tiempoEjecucion"]             = get_micro_time()-$tiempoinicial;
	$datosProcesados["retroalimentacionParametros"] = moduloPrincipalRetroalimentacionParametros($datosProcesados);
	moduloPrincipalImprimirSalidaLog($datosProcesados);
	return $datosProcesados;
}
//function
function moduloPrincipalRetroalimentacionParametros($datosProcesados) {
	$contador = 0;
	foreach ($datosProcesados as $key => $value) {
		if ($value == null || $value == "") {
			json_encode($retoalimentacion[$key] = "No contiene valores");
		}
		$json = json_encode($retoalimentacion);
	}//foreach
	if ($json == null || $json == "null" || $json == "") {
		return "Los parametros son correctos ";
	} else {
		return $json;
	}//else
}//function

function moduloPrincipalCodificacionParametros($datosEntrada) {
	foreach ($datosEntrada as $key => $value) {
		$codificacion      = mb_detect_encoding($str);
		$datosSalida[$key] = mb_convert_encoding($value, "UTF-8", $codificacion);
	}//foreach
	return $datosSalida;

}//function

function revisionParametrosReiniciar() {
	$directorio = dirname(__FILE__);
	$archivo    = $directorio.'/LOG/revisionParametros.txt';
	$f          = fopen($archivo, "a");
	$cad        = print_r($parametro, true);
	$cad .= "\n\n";
	return fwrite($f, $cad);
}
//function

function revisionParametros($parametro) {
	$directorio = dirname(__FILE__);
	$archivo    = $directorio.'/LOG/revisionParametros.txt';
	$f          = fopen($archivo, "a+");
	$cad        = print_r($parametro, true);
	$cad .= "\n\n";
	return fwrite($f, $cad);
}
//function
//

function logWebservice($parametro) {
	$directorio = dirname(__FILE__);
	$archivo    = $directorio.'/LOG/logWebservices.txt';
	$f          = fopen($archivo, "a+");
	$cad        = print_r($parametro, true);
	$cad .= "\n\n";
	return fwrite($f, $cad);
}
//function

function obj2array($object) {
	if (is_array($object) || is_object($object)) {
		$array = array();
		foreach ($object as $key => $value) {
			$array[$key] = obj2array($value);
		}
		//Foreach
		return $array;
	}
	//IF
	return utf8_encode($object);
}
//function

function array2obj($datosEntrada) {
	if (!is_object($datosEntrada)) {
		return $datosEntrada = (object) $datosEntrada;
	}
}
//function

function idRecursoActividad($datos) {
	$modulos = get_records('modules');
	foreach ($modulos as $modulo) {
		if ("'".$modulo->name."'" == "'".$datos->name."'") {
			return $modulo->id;
		}
		//If

	}
	//Foreach

}
//function
//echo idRecursoActividad();
//exit;
function full_copy($source, $target) {
	if (is_dir($source)) {
		@mkdir($target);
		$d = dir($source);
		while (FALSE !== ($entry = $d->read())) {
			if ($entry == '.' || $entry == '..') {
				continue;
			}
			$Entry = $source.'/'.$entry;
			if (is_dir($Entry)) {
				full_copy($Entry, $target.'/'.$entry);
				continue;
			}

			copy($Entry, $target.'/'.$entry);
		}
		$d->close();
	} else {
		copy($source, $target);
	}
	//Else

}
//function
/////////////////////////////////////////////////////////////////////////////////

function moduloPrincipalArchivosMoodle() {
	$archivosMoodle = 0;
	if ($archivosMoodle == 1) {
		require_once ($CFG->dirroot.'/lang/en_utf8/chat.php');
		// Conexion a la Base de datos de Moodle
		require_once ($CFG->dirroot.'/backup/lib.php');
		require_once ($CFG->dirroot.'/backup/backuplib.php');
		require_once ($CFG->dirroot.'/backup/restorelib.php');
		require_once ($CFG->dirroot.'/question/restorelib.php');
		require_once ($CFG->dirroot.'/question/backuplib.php');
		require_once ($CFG->libdir.'/accesslib.php');
		require_once ($CFG->libdir.'/adminlib.php');
		require_once ($CFG->libdir.'/authlib.php');
		require_once ($CFG->libdir.'/blocklib.php');
		require_once ($CFG->libdir.'/gradelib.php');
		require_once ($CFG->libdir.'/grouplib.php');
		require_once ($CFG->libdir.'/formslib.php');
		require_once ($CFG->dirroot.'/group/lib.php');
		require_once ($CFG->dirroot.'/notes/lib.php');
		require_once ($CFG->dirroot.'/lib/filelib.php');
		require_once ($CFG->dirroot.'/lib/setup.php');
		if ($allmods = get_records("modules")) {
			foreach ($allmods as $mod) {
				$modname  = $mod->name;
				$modfile0 = "$CFG->dirroot/mod/$modname/lib.php";
				$modfile1 = "$CFG->dirroot/mod/$modname/restorelib.php";
				$modfile2 = "$CFG->dirroot/mod/$modname/backuplib.php";
				if (file_exists($modfile0)) {
					include_once ($modfile0);
				}
				if (file_exists($modfile1)) {
					include_once ($modfile1);
				}
				if (file_exists($modfile2)) {
					include_once ($modfile2);
				}
			}
			//Foreach que reorre todos los archivos LIB de php

		}
		//If

	}
	//validamos la badera de $archivosMoodle

}
//function

//TODO validar si estas funciones son relevantes
function urlcursomoodle() {
	moduloPrincipalFuncionesInicio();
	$salida = $CFG->wwwroot;
	moduloPrincipalFuncionesCierre();
	return $salida;
}
//function

function urlportada() {
	ob_start();
	//Para evitar que imprima los echos
	global $CFG;
	$salida = $CFG->www_sitedir;
	ob_end_clean();
	//Para que no imprima los echos
	return $salida;
}
//function
function urlcurso() {
	ob_start();
	//Para evitar que imprima los echos
	global $CFG;
	$salida = $CFG->wwwroot;
	ob_end_clean();
	//Para que no imprima los echos
	return $salida;
}
//function

function imprimirSalida($parametros) {
	echo "<pre>";
	print_r($parametros);
	exit;
}

function fechaActual() {
	$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$arrayDias  = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
	return $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y');
}
?>
