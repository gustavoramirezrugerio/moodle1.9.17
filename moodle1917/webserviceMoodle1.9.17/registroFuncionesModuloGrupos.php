<?php
// REGISTRO DE FUNCIONES DEL MODULO DE GRUPOS
$server->register(
'modulogruposRegistrarGrupo',
array('grupo' => 'tns:grupo' ),
array('newGrupo' => 'tns:curso'));

$server->register(
'modulogruposObtenerGrupos',   						// Nombre del Método
array('curso' => 'tns:curso' ),           // Parámetros de Entrada
array('cursoGrupos' => 'tns:curso')   //Datos de Salida
);


// No funciona
$server->register(
	'modulogruposEditarGrupo',   						// Nombre del Método
array('grupo' => 'tns:grupo' ),           // Parámetros de Entrada
array('grupoEditarOut' => 'tns:curso')   //Datos de Salida
);


$server->register(
'modulogruposEliminarGrupo',   						// Nombre del Método
array('grupo' => 'tns:grupo' ),           // Parámetros de Entrada
array('grupoEliminarOut' => 'tns:curso')   //Regresa un curso con todos sus grupos registtrados.
);

// TODO Registar  la funcion:: modulogruposEnrolarEnGrupo


$server->register(
	'modulogruposRegistrarGrupoAuto',   						// Nombre del Método
array('grupo' => 'tns:grupo' ),           // Parámetros de Entrada
array('grupoEliminarOut' => 'tns:curso')   //Regresa un curso con todos sus grupos registtrados.
);	




?>
