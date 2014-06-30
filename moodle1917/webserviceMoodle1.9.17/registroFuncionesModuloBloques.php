<?php
// REGISTRO DE FUNCIONES DE BLOQUES
$server->register(
'modulobloquesAgregarBloque',   						// Nombre del Método
array('chatIn' => 'tns:bloque' ),           // Parámetros de Entrada
array('chatOut' => 'tns:bloque')   //Datos de Salida
);

$server->register(
'modulobloquesEliminarBloque',   						// Nombre del Método
array('chatIn' => 'tns:bloque' ),           // Parámetros de Entrada
array('chatOut' => 'tns:bloque')   //Datos de Salida
); 

$server->register(
'modulobloquesOcultarMostrarBloques',   						// Nombre del Método
array('chatIn' => 'tns:bloque' ),           // Parámetros de Entrada
array('chatOut' => 'tns:bloque')   //Datos de Salida
);

$server->register(
'modulobloquesMoveLeftRightBlock',   						// Nombre del Método
array('chatIn' => 'tns:bloque' ),           // Parámetros de Entrada
array('chatOut' => 'tns:bloque')   //Datos de Salida
);

?>
