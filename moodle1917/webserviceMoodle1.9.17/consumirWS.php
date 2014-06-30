<?php
require_once ('../config.php');
// Conexion a la Base de datos de Moodle
//---->
require_once ('nusoap-0.9.5/lib/nusoap.php');
// Llamado a la libreria
$server = new soap_server;
$ns     = "http://webServices.moodle.gestor.mx";
// espacio de nombres; Sitio donde estará alojado el web service
$server->configurewsdl('MoodleWS', $ns);
//nombre del web service
$xmls = new XMLSchema();
$xmls->parseFile("moodle.xsd", "schema");
$xsc               = $server->wsdl->schemas[$ns][0];
$xsc->complexTypes = $xmls->complexTypes;
$xsc->elements     = $xmls->elements;
/*METODO DEL WEB SERVICE*/
require_once ('./parametrosFunciones.php');
require_once ('./funcionesPrincipales.php');
require_once ('./moduloCategorias.php');
/******************************************************************/
/*                         Obtener Categoria                      */
/******************************************************************
require_once ('./moduloCursos.php');
require_once ('./moduloRoles.php');
require_once ('./moduloGrupos.php');
require_once ('./moduloUsuarios.php');
require_once ('./moduloBloques.php');
require_once ('./moduloCalificaciones.php');
require_once ('./moduloEncuestas.php');
require_once ('./moduloModulos.php');
/******************************************************************/
/*                     REGISTRANDO EL METODO                      */
/******************************************************************/
require_once ('./registroFuncionesModuloCategorias.php');
require_once ('./registroFuncionesModuloCursos.php');
require_once ('./registroFuncionesModuloRoles.php');
require_once ('./registroFuncionesModuloGrupos.php');
require_once ('./registroFuncionesModuloUsuarios.php');
require_once ('./registroFuncionesModuloBloques.php');
require_once ('./registroFuncionesModuloCalificaciones.php');
require_once ('./registroFuncionesModuloEncuestas.php');
require_once ('./registroFuncionesModuloModulos.php');
/******************************************************************/
/*         PROCESA LA SOLICITUD Y DEVUELVE LA RESPUESTA           */
/******************************************************************/
$input = (isset($HTTP_RAW_POST_DATA))?$HTTP_RAW_POST_DATA:implode("\r\n", file('php://input'));
$server->service($input);
exit;
?>
