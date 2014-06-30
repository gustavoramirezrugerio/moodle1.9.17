<?php
// REGISTRO DE FUNCIONES DEL MODULO DE ROLES

$server->register(
'modulorolesObtenerRoles',   						// Nombre del Método
array('rolIn' => 'tns:rol'  ),           // Parámetros de Entrada
array('rolOut' => 'tns:rol')   //Datos de Salida
);

// -------

$server->register(
'modulorolesAsignarRol',   						// Nombre del Método
array('rolasingIn' => 'tns:rolasing' ),           // Parámetros de Entrada
array('rolasingOut' => 'tns:rolasing')   //Datos de Salida
);

$server->register(
'modulorolesQuitarRol',   						// Nombre del Método
array('rolasingIn' => 'tns:rolasing' ),           // Parámetros de Entrada
array('rolasingOut' => 'tns:rolasing')   //Datos de Salida
);


//////////////////////////////////PENDIENTES POR REVISAR
$server->register( 
'modulorolesObtenerTodosRoles',   						// Nombre del Método
array(),           // Parámetros de Entrada
array('categoriaOut' => 'tns:rol')   //Datos de Salida
);

$server->register(
'modulorolesAdmin',   						// Nombre del Método
array(),           // Parámetros de Entrada
array('categoriaOut' => 'tns:rol')   //Datos de Salida
);

$server->register(
'modulorolesTeacher',   						// Nombre del Método
array(),           // Parámetros de Entrada
array('categoriaOut' => 'tns:rol')   //Datos de Salida
);

$server->register(
'modulorolesStudent',   						// Nombre del Método
array(),           // Parámetros de Entrada
array('categoriaOut' => 'tns:rol')   //Datos de Salida
);











?>
