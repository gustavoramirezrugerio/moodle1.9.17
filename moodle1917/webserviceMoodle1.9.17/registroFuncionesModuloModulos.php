<?php
///////////////////////////////////////REGISTRAR	modulos 	/////////////////////////////////

$server->register(
'modulomodulosRegistraCuestionario',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);


$server->register(
'modulomodulosRegistraEncuesta',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);

$server->register(
'modulomodulosRegistraModuloEncuesta',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);


$server->register(
'modulomodulosRegistrarWiki',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);

$server->register(
'modulomodulosRegistraForo',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);

$server->register(
'modulomodulosRegistraBase',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);

$server->register(
'modulomodulosRegistraGlosario',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);

$server->register(
'modulomodulosRegistraLeccion',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);

$server->register(
'modulomodulosRegistrarAgregarRecurso',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);

$server->register(
'modulomodulosRegistrarSae',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);


$server->register(
'modulomodulosRegistraConsulta',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);

$server->register(
'modulomodulosRegistraScorm',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);

$server->register(
'modulomodulosRegistrarChat',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);

$server->register(
'modulomodulosRegistraTarea',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);


$server->register(
'modulomodulosRegistrarEtiqueta',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);


//----------------------


/*			************	OCULTAR / MOSTRAR	**************					*/


$server->register(
'modulomodulosOcultarMostrarModulos',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);
/*
$server->register(
'modulomodulosOcultarMostrarMoulo',   						// Nombre del Método
array('chatIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('chatOut' => 'tns:cursoModulos')   //Datos de Salida
);
*/


///////////////////////////////////////	EDITAR	modulos 	/////////////////////////////////

$server->register(
	'modulomodulosEditarModulos',   						// Nombre del Método
array('moduloIn' => 'tns:cursoModulos','chatin'=>'tns:chat'),           // Parámetros de Entrada
array('moduloOut' => 'tns:cursoModulos')   //Datos de Salida
//array('moduloOut' => 'xsd:string)   //Datos de Salida
);


$server->register(
	'modulomodulosEditartiqueta',   						// Nombre del Método
array('moduloIn' => 'tns:cursoModulos'),           // Parámetros de Entrada
array('moduloOut' => 'tns:cursoModulos')   //Datos de Salida
);



///////////////////////////////////////	ELIMINAR	modulos 	/////////////////////////////////


$server->register(
'modulomodulosEliminarModulos',   						// Nombre del Método
array('moduloIn' => 'tns:cursoModulos' ),           // Parámetros de Entrada
array('moduloOut' => 'tns:cursoModulos')   //Datos de Salida
);





?>
