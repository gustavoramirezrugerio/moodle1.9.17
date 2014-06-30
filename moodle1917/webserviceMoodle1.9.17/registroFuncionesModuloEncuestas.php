<?php
// REGISTRO DE FUNCIONES DEL MODULO DE ENCUESTAS
$server->register(
'moduloEncuestasRegistrarEncuestas',   						// Nombre del Método
array('EncuestaIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('EncuestaOut' => 'tns:cursoModulos')   //Datos de Salida
);


$server->register(
'moduloEncuestasObtenerEncuestas',   						// Nombre del Método
array('EncuestaIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('EncuestaOut' => 'tns:encuestas')   //Datos de Salida
);


$server->register(
'moduloEncuestasObtenerTiposEncuestasGenerales',   						// Nombre del Método
array('EncuestaIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('EncuestaOut' => 'tns:tiposencuestas')   //Datos de Salida
);

$server->register(
'moduloEncuestasRegistrarTiposEncuestasGenerales',   						// Nombre del Método
array('EncuestaIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('EncuestaOut' => 'tns:tiposencuestas')   //Datos de Salida
);


$server->register(
'moduloEncuestasActualizarTiposEncuestasGenerales',   						// Nombre del Método
array('EncuestaIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('EncuestaOut' => 'tns:tiposencuestas')   //Datos de Salida
);


$server->register(
'moduloEncuestasDireccionarEncuestas',   						// Nombre del Método
array('EncuestaIn' => 'tns:curso' ),           // Parámetros de Entrada
array('EncuestaOut' => 'xsd:string')   //Datos de Salida
);

$server->register(
'moduloEncuestasResponderEncuesta',   						// Nombre del Método
array('EncuestaIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('EncuestaOut' => 'xsd:string')   //Datos de Salida
);




?>
