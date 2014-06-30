<?php
// REGISTRO DE FUNCIONES DEL MODULO DE CATEGORIAS

$server->register(
'modulocategoriasRegistrarCategoria',   						// Nombre del Método
array('categoriaIn' => 'tns:categoria' ),           // Parámetros de Entrada
array('agregadoOut' => 'tns:categoria')   //Datos de Salida
);

// $server->register(
// 'modulocategoriasRegistrarCategoria',   						// Nombre del Método
// array('categoriaIn' => 'tns:categoria' ),           // Parámetros de Entrada
// array('agregadoOut' => 'tns:categoria', 'error' => 'xsd:string')   //Datos de Salida
// );


// $server->register(
// 'modulocategoriasRegistrarCategoria',   						// Nombre del Método
// array('categoriaIn' => 'tns:categoria' ),           // Parámetros de Entrada
// array('return' => 'xsd:string')   //Datos de Salida
// );


$server->register(
'modulocategoriasObtenerCategorias',   						// Nombre del Método
array('categoriaIn' => 'tns:categoria' ),           // Parámetros de Entrada
array('categoriaOut' => 'tns:categoria')   //Datos de Salida
);

$server->register(
'modulocategoriasEditarCategoria',   						// Nombre del Método
array('categoriaIn' => 'tns:categoria' ),           // Parámetros de Entrada
array('categoriaOut' => 'tns:categoria')   //Datos de Salida
);

$server->register(
'modulocategoriasEliminarCategoria',         // Nombre del MÃ©todo
array('categoriain' => 'tns:categoria'),           // ParÃ¡metros de Entrada
array('categoriaOut' => 'tns:categoria')   //Regresa un grupo con todos sus usuarios registrados
);



// --------------
$server->register(
'modulocategoriasOcultarMostrarCategoria',         // Nombre del MÃ©todo
array('categoriain' => 'tns:categoria'),           // ParÃ¡metros de Entrada
array('categoriaOut' => 'tns:categoria')   //Regresa un grupo con todos sus usuarios registrados
);

$server->register(
'modulocategoriasObtenerProyectos',   						// Nombre del Método
array('categoriaIn' => 'tns:categoria' ),           // Parámetros de Entrada
array('categoriaOut' => 'tns:categoria')   //Datos de Salida
);

$server->register(
 'modulocategoriasMoverArribaCategoria',         // Nombre del MÃ©todo
array('categoriain' => 'tns:categoria'),           // ParÃ¡metros de Entrada
array('categoriaOut' => 'tns:categoria')   //Regresa un grupo con todos sus usuarios registrados
);

$server->register(
 'modulocategoriasMoverAbajoCategoria',         // Nombre del MÃ©todo
array('categoriain' => 'tns:categoria'),           // ParÃ¡metros de Entrada
array('categoriaOut' => 'tns:categoria')   //Regresa un grupo con todos sus usuarios registrados
);


$server->register(
                'modulocategoriasObtenerCategoriasConCursos',                                                   // Nombre del Método
                array(),           // Parámetros de Entrada
                array('categoriaOut' => 'tns:categoria')   //Datos de Salida
);


//ESTAS NO LAS TENIA

$server->register(
		'modulocategoriasMoverCurso',   						// Nombre del Método
		array('cursoIn' => 'tns:curso','categoriaIn' => 'tns:categoria'),           // Parámetros de Entrada
		array('cursoOut' => 'tns:curso')   //Datos de Salida
);


$server->register(
		'modulocategoriasMoverCategoria',   						// Nombre del Método
		array('categoriaIn' => 'tns:categoria'),           // Parámetros de Entrada
		array('categoriaOut' => 'tns:categoria')   //Datos de Salida
);



?>
