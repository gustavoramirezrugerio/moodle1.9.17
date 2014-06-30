<?php
// REGISTRO DE FUNCIONES DEL MODULO DE CURSOS

$server->register(
	'modulocursosRegistrarCurso',   						// Nombre del Método
array('cursoIn' => 'tns:curso' ),           // Parámetros de Entrada
array('cursoOut' => 'tns:curso')   //Datos de Salida
);

$server->register(
		'modulocursosDetallesCurso',   						// Nombre del Método
		array('cursoIn' => 'tns:curso' ),           // Parámetros de Entrada
		array('cursoOut' => 'tns:curso')   //Datos de Salida
);

$server->register(
		'modulocursosDetallesCursoXnombreCorto',   						// Nombre del Método
		array('cursoIn' => 'tns:curso' ),           // Parámetros de Entrada
		array('cursoOut' => 'tns:curso')   //Datos de Salida
);



$server->register(
		'modulocursosObtenerSeccion',   						// Nombre del Método
		array('cursoIn' => 'tns:curso' ),           // Parámetros de Entrada
		array('cursoOut' => 'tns:secciones')   //Datos de Salida
);

$server->register(
'modulocursosObtenerCursos',   						// Nombre del Método
array('categoriaIn' => 'tns:categoria' ),           // Parámetros de Entrada
array('cursosOut' => 'tns:categoria')   //Datos de Salida
);

$server->register(
'modulocursosEditarCurso',   						// Nombre del Método
array('cursoIn' => 'tns:curso' ),           // Parámetros de Entrada
array('cursoOut' => 'tns:curso')   //Datos de Salida
);

$server->register(
'modulocursosActualizarSemanas',   						// Nombre del Método
array('cursoIn' => 'tns:curso' ),           // Parámetros de Entrada
array('cursoOut' => 'tns:curso')   //Datos de Salida
);


$server->register(
'modulocursosEliminarCurso',   						// Nombre del Método
array('cursoIn' => 'tns:curso' ),           // Parámetros de Entrada
array('cursoOut' => 'tns:curso')   //Datos de Salida
);
//-------------------

$server->register(
'modulocursosOcultarMostrarCurso',         // Nombre del MÃ©todo
array('cursoin' => 'tns:curso'),           // ParÃ¡metros de Entrada
array('cursoOut' => 'tns:curso')   //Regresa un grupo con todos sus usuarios registrados
);

//*****ADD
$server->register(
 'modulocursosMoverArribaCurso',         // Nombre del MÃ©todo
array('cursoin' => 'tns:curso'),           // ParÃ¡metros de Entrada
array('cursoOut' => 'tns:curso')   //Regresa un grupo con todos sus usuarios registrados
);

$server->register(
 'modulocursosMoverAbajoCurso',         // Nombre del MÃ©todo
array('cursoin' => 'tns:curso'),           // ParÃ¡metros de Entrada
array('cursoOut' => 'tns:curso')   //Regresa un grupo con todos sus usuarios registrados
);


$server->register(
 'modulocursosObtenerRecursosActividades',         // Nombre del MÃ©todo
array('actividadesrecursosin' => 'xsd:string'),           // ParÃ¡metros de Entrada
array('actividadesrecursosOut' => 'tns:menuRecursosActividades')   //Regresa un grupo con todos sus usuarios registrados
);


$server->register(
 'modulocursosEditarSeccion',         // Nombre del MÃ©todo
array('seccionin' => 'tns:seccion'),           // ParÃ¡metros de Entrada
array('seccionOut' => 'tns:seccion')   //Regresa un grupo con todos sus usuarios registrados
);


$server->register(
		'modulocursosRegistrarBackup',         // Nombre del MÃ©todo
		array('seccionin' => 'tns:curso'),           // ParÃ¡metros de Entrada
		array('seccionOut' => 'xsd:string')   //Regresa un grupo con todos sus usuarios registrados
);


$server->register(
		'modulocursosRestaurarCurso',         // Nombre del MÃ©todo
		array('seccionin' => 'tns:curso'),           // ParÃ¡metros de Entrada
		array('seccionOut' => 'xsd:string')   //Regresa un grupo con todos sus usuarios registrados
);

$server->register(
		'modulocursosReiniciarCurso',         // Nombre del MÃ©todo
		array('seccionin' => 'tns:curso'),           // ParÃ¡metros de Entrada
		array('seccionOut' => 'xsd:string')   //Regresa un grupo con todos sus usuarios registrados
);



$server->register(
		'modulocursosObtenerSemanas',         // Nombre del MÃ©todo
		array('semanasin' => 'tns:curso'),           // ParÃ¡metros de Entrada
		array('semanasOut' => 'tns:curso')   //Regresa un grupo con todos sus usuarios registrados
);

$server->register(
		'modulocursosObtenerRecursosActividadesCurso',         // Nombre del MÃ©todo
		array('semanasin' => 'tns:curso'),           // ParÃ¡metros de Entrada
		array('semanasOut' => 'tns:curso')   //Regresa un grupo con todos sus usuarios registrados
);





$server->register(
'modulocursosLimpiarCurso',         // Nombre del MÃ©todo
array('cursoin' => 'tns:curso'),           // ParÃ¡metros de Entrada
array('cursoOut' => 'xsd:string')   //Regresa un grupo con todos sus usuarios registrados
);



//REVISAR ESTOS

$server->register(
 'modulocursosExisteCurso',         // Nombre
 array('cursoIn' => 'xsd:string' ),           // Entrada
 array('cursoOut' => 'xsd:boolean')   //Datos de Salida
);




?>