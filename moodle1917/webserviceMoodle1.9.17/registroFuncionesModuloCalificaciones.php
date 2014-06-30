<?php
$server->register(
	'modulocalificacionesUsuario',   						// Nombre del Método
array('usuarioIn' => 'tns:usuario', 'cursoIn'=> 'tns:curso' ),           // Parámetros de Entrada
array('calificacionesOut' => 'tns:calificaciones')   //Datos de Salida
);


?>
