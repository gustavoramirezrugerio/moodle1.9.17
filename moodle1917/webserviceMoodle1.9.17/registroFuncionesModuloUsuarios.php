<?php
$server->register(
'modulousuariosObtenerUsuariosGrupo',   						// Nombre del Método
array('grupoin' => 'tns:grupo' ),           // Parámetros de Entrada
array('grupoOut' => 'tns:grupo')   //Regresa un grupo con todos sus usuarios registrados
);

$server->register(
'modulousuariosDesmatricularUsuarios',   						// Nombre del Método
array('usuariosin' => 'tns:listaUsuarios', 'grupoin'=>'tns:grupo' ),           // Parámetros de Entrada
array('usuariosOut' => 'tns:grupo')   //Regresa un grupo con todos sus usuarios registrados
);


$server->register(
'modulousuariosDesmatricularUsuariosGrupo',
array('usuariosin' => 'tns:listaUsuarios', 'grupoin'=>'tns:grupo' ),           // Parámetros de Entrada
array('grupoOut' => 'tns:grupo')   //Regresa un grupo con todos sus usuarios registrados
);



$server->register(
'modulousuariosMatricularUsuariosSingrupo',
array('usuariosin' => 'tns:listaUsuarios', 'grupoin'=>'tns:grupo' ),           // Parámetros de Entrada
array('grupoOut' => 'xsd:string')   //Regresa un grupo con todos sus usuarios registrados
//comentario WS
);



//--- tns:listaUsuarios
$server->register(
'modulousuariosObtenerUsuariosRegistrados',   						// Nombre del Método
array('cursoin' => 'tns:curso' ),           // Parámetros de Entrada
array('usuariosOut' => 'tns:listaUsuarios')   //Regresa una lista con todos los usuarios registrados en el curso de entrada.
);

$server->register(
'modulousuariosMatricularUsuarios',   						// Nombre del Método
array('usuariosin' => 'tns:listaUsuarios', 'grupoin'=>'tns:grupo' ),           // Parámetros de Entrada
array('usuariosOut' => 'tns:grupo')   //Regresa un grupo con todos sus usuarios registrados
);


$server->register(
'modulousuariosMatricularResponsables',   						// Nombre del Método
array('usuariosin' => 'tns:listaUsuarios', 'cursoin'=>'tns:curso' ),           // Parámetros de Entrada
array('usuariosOut' => 'tns:listaUsuarios')   //Regresa un grupo con todos sus usuarios registrados
);




$server->register(
'modulousuariosMatricularUsuariosCursoGrupo',   						// Nombre del Método
array('usuariosin' => 'tns:listaUsuarios', 'grupoin'=>'tns:grupo' ),           // Parámetros de Entrada
array('usuariosOut' => 'tns:grupo')   //Regresa un grupo con todos sus usuarios registrados
);


$server->register(
'modulousuariosObtenerPerfilUsuario',         // Nombre del MÃ©todo
array('usuario' => 'tns:usuario'),           // ParÃ¡metros de Entrada
array('usuariosPerfil' => 'tns:usuario')   //Regresa perfil de usuario
);


$server->register('modulousuariosEditarUsuario',
array('usuario' => 'tns:usuario' ),
array('agregado' => 'tns:usuario'));

$server->register(	'modulousuariosObtenerTodosUsuarios',   						// Nombre del Método
array('userin' => 'tns:usuario' ),           // Parámetros de Entrada
array('userOut' => 'tns:usuario')   //Regresa un grupo con todos sus usuarios registrados
); 

$server->register(
	'modulousuariosObtenerCalificacionesUsuario',   						// Nombre del Método
array('calificacionesIn' => 'tns:calificaciones' ),           // Parámetros de Entrada
array('calificacionesOut' => 'tns:calificaciones')   //Datos de Salida
);

?>
